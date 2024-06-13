<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('front/coreui/vendors/simplebar/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{asset('front/coreui/css/vendors/simplebar.css')}}">
    <!-- Main styles for this application-->
    <link href="{{asset('front/coreui/icons/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('admin/coreui/css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{asset('front/coreui/css/examples.css')}}" rel="stylesheet">
    @stack('head-scripts')
</head>
<body>
@yield('content')
<!-- CoreUI and necessary plugins-->
<script src="{{asset('front/coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('front/coreui/vendors/simplebar/js/simplebar.min.js')}}"></script>
@stack('footer-scripts')

</body>
</html>
