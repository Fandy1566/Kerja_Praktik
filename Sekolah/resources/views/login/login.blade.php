<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font.css') }}" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="left-side" style="width:60vw; height:100%; background-color: white;">
        <img src="{{asset('image/picture/login2.png')}}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="right-side" style="width:40vw; height:100%; background-color: white; padding-top: 100px; padding-bottom: 100px">
            <div class="title-login">
                Time Schedule Jadwal Pembelajaran SMP Negeri 23 Palembang
            </div>
            <div class="logo">
                <div class="logo-smp"><img src="{{asset('image/picture/Logo.png')}}" alt=""></div>
            </div>
            <div class="sub-title-login">
                <div class="sub-title-primary">
                    Hello Admin!
                </div>
                <div class="sub-title-sub-primary">
                    Lakukan pembuatan jadwal pembelajaran yang efisien
                </div>
            </div>
            <div class="login-input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    <label for="">Password</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password" required autocomplete="current-password" >
            </div>
            <div class="login-help">
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <div class="rem-title">Remember Me</div>
                </div>
                {{-- <div class="" style="display: flex; align-items: center;">
                    <button id="recorvery">Recorvery Password?</button>
                </div> --}}
            </div>
            <button type="submit">
                {{ __('Log in') }}
            </button>
            @if ($errors->has('email'))
                <span class="invalid-feedback" style="color:red; display:flex; justify-content:center;margin-top: 8px; font-size:10px">
                    Email / Password Salah
                </span>
            @endif
        </div>
    </form>
</body>
</html>