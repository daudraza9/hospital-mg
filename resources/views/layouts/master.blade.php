<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<div id="preloaders" class="preloader"></div>
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

