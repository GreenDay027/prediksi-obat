<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - Prediksi Obat Apotek K-24</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .login {
            display: flex;
            justify-content: center; /* Memusatkan secara horizontal */
            align-items: center; /* Memusatkan secara vertikal jika diperlukan */
        }
    </style>
</head>

<body class="account-page" style="background-color: rgb(243, 223, 168)">

    <div class="container">
        <div class="login-wrapper my-5"
            style="border-radius:16px; border: 2px solid rgb(255, 166, 0);box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;background-color: white;height:700px">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login mx-auto justify-center">
                        <img src="assets/img/logo-prediksi.png" alt="img" style="width: 200px;">
                    </div>
                    <div class="login-userheading">
                        <h3>Sign In</h3>
                        <h4>Please login to your account</h4>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-login">
                            <label>Email</label>
                            <div class="form-addons">
                                <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}">
                                <img src="assets/img/icons/mail.svg" alt="img">
                            </div>
                            @if ($errors->has('email'))
                                <div class="text-danger fw-bold">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" name="password" placeholder="Enter your password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            @if ($errors->has('password'))
                                <div class="text-danger fw-bold">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-login">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-img">
                <img src="assets/img/Apotek-K-24.jpg" alt="img">
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
