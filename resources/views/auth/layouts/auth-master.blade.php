<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('auth.layouts.auth-header')

<body>

@yield('content')


@include('layouts.scripts')
</body>
</html>
