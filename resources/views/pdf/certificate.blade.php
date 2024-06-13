<!doctype html>
<html lang="en">
<style>

    @page {
        margin: 0px !important;
        padding: 0px !important;
    }

    body {
        background-color: #ffffff;
        border: 3px solid #000;
        margin: 16px;
    }

    /*body {*/
    /*    background-color: #ffffff;*/
    /*}*/

    .underline {
        text-decoration: none;
        position: relative;
    }

    .underline:after {
        position: absolute;
        content: '';
        height: 2px;
        bottom: -2px;
        margin: 0 auto;
        left: 0;
        right: 0;
        width: 25%;
        background: black;
    }

    img {
        width: 40%;
    }

    .bg {
        /* background-image: url("





    {{URL('/')}}      /front/images/pdf/bg.png"); */
        background-color: #ffffff;
        background-size: 200px 200px;
    }
</style>
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>

</head>
<body>
<div class="bg" style="height: 680px;">

    <div style="width: 40%;  margin:70px 0 0 43%">
        <img  src="{{asset('/front/coreui/assets/img/logo-sm-new.png')}}" alt="">
    </div>
    {{-- <div style="width: 17%;  margin-top:15px; float: left">
        <img src="{{asset('front/images/dermal-logo.png')}}" alt="" style="margin-left: 120px;">
    </div>
    <div style="width: 52%;  margin-top:15px; float: right">
        <img src="{{asset('front/images/umdc-logo.png')}}" alt="" style="margin-left: 220px;">
    </div> --}}

    <div style="width: 80%; margin:8% 0 0 10%">
        <div>
            <p style="text-align: center; font-size: 38px; font-weight: bold;margin: 10px 0 0 0;">CERTIFICATE </p>
            <p style="text-align: center; font-size: 18px; margin-top: 2px;">OF ATTENDANCE</p>
        </div>
        <div style="text-align: center">
            <span style="text-align: center; font-size: 20px;">This is to Certify that</span><br>
            <span style="text-align: center; font-size: 24px; font-weight: bold;margin-top: 10px">
                <span>{{$certificate->title}}.</span> {{$certificate->name}}</span>
            <p style="text-align: center; font-size: 20px; margin-top: -18px;font-weight: bold;">
                ______________________________________</p>
        </div>
        <div style="margin:0 0 0 0; text-align: center">
            <span style=" text-align: center; font-size: 20px;">Has Attended</span><br>
            <span style="text-align: center; font-size: 18px;"><span
                    style="font-weight: bold;"> {{$certificate->event_name}}</span> in <span
                    style="font-weight: bold;"> {{$certificate->venue}}</span></span><br>
            <span style="font-size: 18px;">
                From {{ \Carbon\Carbon::parse($certificate->start_date)->format('F d, Y')}}
                to {{ \Carbon\Carbon::parse($certificate->end_date)->format('F d, Y')}}
            </span>
        </div>
        <div style="margin: 90px 0 0 0;">
            <div style="height: 30%; width: 35%; float: left; text-align: center">
                {{--                <img src="{{URL('/')}}/front/images/pdf/pb.png" alt=""--}}
                {{--                     style="height: 100%; width: 100%; padding-left: 0%; object-fit: contain;">--}}
                <p>________________________________</p>
                <p style="font-size: 18px; font-weight: bold;margin-top: -6px;">President of International Conference of
                    Advance STEAM Education</p>
            </div>
        </div>

    </div>
</div>


{{--{{die()}}--}}
</body>
</html>
