<!DOCTYPE html>
<html lang="en">
<head>
    @include('front.layouts.head')
    @stack('head-scripts')
</head>
<body>
    <div class="body-wrap">

    @include('front.layouts.header')
    @yield('content')
    @include('front.layouts.footer')
    @include('front.layouts.scripts')
    
    </div>
    @stack('footer-scripts')
</body>
</html>