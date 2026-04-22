<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Faktur;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class FakturController extends Controller
{

    public function index(Request $request)
    {
        $today = Carbon::today();
        $query = Faktur::with('distributor');

        if ($request->has('search') && trim($request->search) !== '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                ->orWhereHas('distributor', function ($d) use ($search) {
                    $d->where('nama_distributor', 'like', "%{$search}%");
                });
            });
        }

        if ($request->status == 'darurat') {
            $query->whereDate('tanggal_jatuh_tempo', '<=', $today->copy()->addDays(3));
        }

        if ($request->status == 'dipantau') {
            $query->whereDate('tanggal_jatuh_tempo', '>', $today->copy()->addDays(3))
                ->whereDate('tanggal_jatuh_tempo', '<', $today->copy()->addDays(14));
        }

        if ($request->status == 'aman') {
            $query->whereDate('tanggal_jatuh_tempo', '>=', $today->copy()->addDays(14));
        }

        $fakturs = $query
            ->orderBy('created_at', 'asc')
            ->get();

        return view('faktur.indexFaktur', compact('fakturs'));
    }



    public function create()
    {
        $distributors = Distributor::all();
        return view('faktur.createFaktur', compact('distributors'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'distributor_id' => 'required',
            'tagihan' => 'required|numeric|gt:0',
            'tanggal_faktur' => 'required|date|after_or_equal:today',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_faktur',
        ]);

        Faktur::create([
            'distributor_id' => $request->distributor_id,
            'tagihan' => $request->tagihan,
            'tanggal_faktur' => $request->tanggal_faktur,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo
        ]);

        return redirect()->route('faktur.index')->with('success', 'Faktur berhasil ditambahkan');
    }



    public function edit(Faktur $faktur)
    {
        $faktur = Faktur::findOrFail($faktur->id);
        $distributors = Distributor::all();
        return view('faktur.editFaktur', compact('faktur','distributors'));
    }



    public function update(Request $request, Faktur $faktur)
    {
        $request->validate([
    'distributor_id' => 'required',
    'tagihan' => 'required|numeric|gt:0',
    'tanggal_faktur' => 'required|date',
    'tanggal_jatuh_tempo' => 'required|date',
], [
    'tagihan.gt' => 'Tagihan tidak boleh 0 atau kurang.',
]);

        $faktur = Faktur::findOrFail($faktur->id);
        $faktur->update($request->all());

        return redirect()->route('faktur.index')->with('success', 'Faktur berhasil diperbarui');
    }




    public function destroy(Faktur $faktur)
    {
        Faktur::findOrFail($faktur->id);
        $faktur->delete();
        return back()->with('success', 'Faktur berhasil dihapus');
    }


    public function show($id)
    {
        $faktur = Faktur::with('distributor')->findOrFail($id);
        return view('faktur.showFaktur', compact('faktur'));
    }

    




public function payment($id)
{
    $faktur = Faktur::with('distributor')->findOrFail($id);

    // SETUP MIDTRANS
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => 'FAKTUR-' . $faktur->id . '-' . time(), // biar unik
            'gross_amount' => (int) $faktur->tagihan,
        ],
        'customer_details' => [
            'first_name' => $faktur->distributor->nama_distributor,
            'phone' => '08123456789', // sementara
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return view('faktur.payment', compact('snapToken', 'faktur'));
}









public function callback(Request $request)
{
    Log::info('MIDTRANS CALLBACK MASUK', $request->all());

    if (str_contains($request->order_id, 'payment_notif_test')) {
        return response()->json(['message' => 'Test Success'], 200);
    }

    $orderId = $request->order_id;
    $status = $request->transaction_status;

    $explode = explode('-', $orderId);
    $fakturId = $explode[1]; 

    $faktur = Faktur::find($fakturId);

    if (!$faktur) {
        return response()->json(['message' => 'Faktur tidak ditemukan'], 404);
    }

    // --- PERUBAHAN DI SINI ---
    if ($status == 'settlement' || $status == 'capture') {
        // Gunakan nama kolom sesuai database: status_pembayaran
        $faktur->update(['status_pembayaran' => 'Lunas']); 
    } elseif ($status == 'pending') {
        $faktur->update(['status_pembayaran' => 'Menunggu Pembayaran']);
    } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
        $faktur->update(['status_pembayaran' => 'Gagal']);
    }
    $faktur->save();

    return response()->json(['message' => 'Success']);
    
}
}