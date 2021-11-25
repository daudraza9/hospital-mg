<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body class="sb-nav-fixed">

<div id="layoutSidenav">
    @include('layouts.top-nav')
    @include('layouts.sidebar')




@yield('content')

    @include('layouts.scripts')

</div>

{{--@include('layouts.footer')--}}
</body>
</html>

