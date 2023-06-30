<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/print.css') }}" rel="stylesheet">

    <!-- Script -->

    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    @yield('content')
</body>
<script type="text/javascript">
    window.print();
</script>
</html>