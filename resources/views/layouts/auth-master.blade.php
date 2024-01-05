<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('/css/user.css') }}" rel="stylesheet">
</head>
<body>
@yield('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('/js/maska-nomera.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/phone.js') }}"></script>
</body>
</html>
