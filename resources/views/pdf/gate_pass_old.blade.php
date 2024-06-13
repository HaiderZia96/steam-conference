<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gate Pass</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }
    </style>

</head>
<body>

<div class="information" style="width: 90%; margin-left: 5%">

    <div style="width: 100%;margin-top: 3%">
        <img src="{{asset('front/coreui/images/tuf_logo.png')}}" style="width: 20%;"/>
    </div>

    <div style="width: 100%;">
        <div style="width: 70%; float: left; border-right: 1px dotted #000; min-height: 200px">
            <div style="width: 100%">
                <div style="width: 70%; float: left">
                    <p style="font-size: 16px; letter-spacing: 1px; word-spacing: 2px; font-weight: bold">
                        {{-- International Conference on Dermal Sciences --}}
                        1st International Conference on Advance STEAM Education
                    </p>
                </div>
                <div style="width: 30%;float: right">
                    <p style="font-size: 16px; letter-spacing: 1px; word-spacing: 2px;text-align: right; margin-right: 10%">
                        Ticket No. {{$user_registration->id}}</p>
                </div>
            </div>
            <div style="width: 100%; margin-top: 7%">

                <table style="width: 97%">
                    <tr>
                        <th><p style="border-bottom: 1px solid #000;">#</p></th>
                        <th><p style="border-bottom: 1px solid #000;">Name</p></th>
                        <th><p style="border-bottom: 1px solid #000;">Email</p></th>
                        <th><p style="border-bottom: 1px solid #000;">Contact</p></th>
                    </tr>
                    <tr style="font-size: 14px;margin-top: -10px;">
                        <td style="border-bottom: 1px solid #000; width: 10px">1</td>
                        <td style="border-bottom: 1px solid #000; text-align: center">{{$user->name}}</td>
                        <td style="border-bottom: 1px solid #000; text-align: center">{{$user->email}}</td>
                        <td style="border-bottom: 1px solid #000; text-align: center">{{$user_registration->contact_no}}</td>
                    </tr>
{{--                    @foreach($user as $key=> $me)--}}
{{--                        <tr style="font-size: 14px">--}}
{{--                            <td style="border-bottom: 1px solid #000; width: 10px">{{$key+2}}</td>--}}
{{--                            <td style="border-bottom: 1px solid #000; text-align: center">{{$me->name}}</td>--}}
{{--                            <td style="border-bottom: 1px solid #000; text-align: center">{{$me->email}}</td>--}}
{{--                            <td style="border-bottom: 1px solid #000; text-align: center">{{$me->phone}}</td>--}}
{{--                        </tr>--}}
{{--                @endforeach--}}
            </div>

        </div>

        <div style="width: 30%; float: right; text-align: center;">
            <div style="width: 95%; float: right; margin-left: 5%;font-size: 14px">
                <p style="font-size: 16px; letter-spacing: 1px; word-spacing: 1px; @if($usersCount == 0) margin-top: 17% @else margin-top: 25%  @endif  ">
                    <b>International Conference on Advance STEAM Education Management</b>
                </p>
                <p>TRAINEES SCIENTIFIC MEETING</p>
                <p>International Scientific Meeting of Trainees at Multidisciplinary Level</p>
            </div>
        </div>
    </div>

</div>
{{--{{die}}--}}
</body>
</html>
