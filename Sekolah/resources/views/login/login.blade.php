<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="circle">

    </div>
    <div class="orang">
        <img src="{{ asset('buk_ery.png') }}" alt="">
    </div>
    <div class="container">
        <div class="logo">
            <div class="logo-border">
                <img src="{{ asset('logo.png') }}" alt="">
            </div>
        </div>
        <div class="welcome">
            Hello Admin!
        </div>
        <form action="" method="post">
            @csrf
            <label for="Email">Email</label>
            <div class="input-border">
                <input type="text" name="email">
                <img src="{{ asset('person.png') }}" alt="">
            </div>
            <label for="Password">Password</label>
            <div class="input-border">
                <input type="password" name="password"> 
                <img src="{{ asset('password.png') }}" alt="">
            </div>
            <div class="options">
                <div class="container-remember-me">
                    <input type="checkbox" name="rememberPassword">
                    <span class="remember-me">Remember Me</span>
                </div>
                <a href="#" class="recovery-password">Recovery Password ?</a>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>