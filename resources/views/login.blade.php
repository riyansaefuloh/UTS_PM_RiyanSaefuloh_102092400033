<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #e6f0fa;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 20px;
        }

        .container {
            max-width: 450px;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            padding: 40px 35px;
            box-shadow: 0 0 8px rgba(0, 120, 255, 0.25);
            border: 3px solid rgba(0, 120, 255, 0.15);
        }

        .signin-content {
            width: 100%;
        }

        .signin-image {
            display: none;
        }

        .signin-form {
            width: 100%;
        }

        .form-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #003d7a;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .sub-text {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            background: #efefef;
            font-size: 15px;
        }

        .form-group input:focus {
            background: #fff;
            border-color: #007bff;
            outline: none;
        }

        #togglePassword {
            display: none;
        }

        .forgot {
            font-size: 13px;
            text-align: right;
            display: block;
            color: #999;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .forgot:hover {
            color: #666;
            text-decoration: underline;
        }

        .form-button {
            text-align: center;
        }

        .form-submit {
            width: 120px;
            padding: 10px;
            background: #004b88;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: .3s;
        }

        .form-submit:hover {
            background: #003b70;
        }
    </style>
</head>

<body>

    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">

                    <div class="signin-form">
                        <h2 class="form-title">Apotik<br>Surya Pharma<br>Medika</h2>

                        <p class="sub-text">Silahkan masuk untuk melanjutkan</p>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}v  
                            </div>
                        @endif

                        <form action="/proseslogin" method="POST" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="name" name="name" id="name" placeholder="name" />
                            </div>

                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input type="password" name="password" id="password" placeholder="Kata Sandi" />
                            </div>

                            <div class="form-button">
                                <input type="submit" class="form-submit" value="Masuk" />
                            </div>

                            <div>
                                 <a href="{{ route('pengguna.create') }}"
                                        class="bg-navy text-white px-5 py-2 rounded-lg flex items-center gap-2">
                                        <i class="fas fa-plus"></i>Register
                                </a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </section>
    </div>

</body>

</html>
