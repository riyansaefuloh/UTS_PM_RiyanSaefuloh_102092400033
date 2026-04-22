<!DOCTYPE html>
<html>
<head>
    <title>Bayar Faktur</title>
</head>
<body>

<h2>Bayar Faktur ID: {{ $faktur->id }}</h2>
<p>Total: Rp {{ number_format($faktur->tagihan,0,',','.') }}</p>

<button id="pay-button">Bayar Sekarang</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function(){
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            alert("Pembayaran berhasil!");
            window.location.href = "/faktur";
        },
        onPending: function(result){
            alert("Menunggu pembayaran");
            window.location.href = "/faktur";
        },
        onError: function(result){
            alert("Pembayaran gagal");
        }
    });
};
</script>

</body>
</html>