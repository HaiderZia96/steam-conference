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

<div style=" width: 100%; background-image: url('{{ asset('user/images/bg/pattern-tiles-with.jpg')}}'); min-height: 255px">
<div class="information" style="width: 96%; margin-left: 1%;  margin-right: 1%">
    <div style="width: 100%; background-color: #fff; margin-top: 1%; padding: 1%; min-height: 223px">


        <div style="width: 50%; float: left; min-height: 200px;">
            <div style="width: 100%">
                <div style="width: 20%; float: left; border-bottom: 1px dotted #000;">
                    <p style="font-size: 16px; margin: 5px 0px 5px 0px;  letter-spacing: 1px; font-weight: bold; word-spacing: 2px; ">
                        Member
                    </p>
                </div>
                <div style="width: 80%;float: right; border-bottom: 1px dotted #000;">
                    <p style="font-size: 16px; margin: 5px 0px 5px 0px; letter-spacing: 1px; word-spacing: 2px; text-align: right; font-weight: bold; color: #a91e24;">
                        {{isset($venue->title) ? ucwords($venue->title) : ''}}</p>
                </div>
            </div>
            <div style="width: 100%; margin-top: 6%">
                <p style="font-size: 12px; letter-spacing: 1px; word-spacing: 2px; text-align: left; margin-bottom: -9px">
                    <b>Name :</b> {{isset($user->name) ? ucwords($user->name) : ''}}</p>
                <p style="font-size: 12px; letter-spacing: 1px; word-spacing: 2px; text-align: left; margin-bottom: -9px">
                    <b>Email :</b><span> {{isset($user->email) ? strtolower($user->email) : ''}}</span></p>
                <p style="font-size: 12px; letter-spacing: 1px; word-spacing: 2px; text-align: left; margin-bottom: 22px">
                    <b>Contact :</b> {{isset($user_registration->contact_no) ? ucwords($user_registration->contact_no) : ''}}</p>
                <p style="font-size: 12px; letter-spacing: 1px; word-spacing: 2px; text-align: left;">
                    {{isset($venue->description) ? $venue->description : ''}}</p>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left; text-align: center;">
                    <img src="{{asset('user/images/logos/top.png')}}" style="width: 70%;"/>
                </div>
                <div style="width: 50%; float: right; text-align: center;">
                    <img src="{{asset('user/images/logos/impact.png')}}" style="width: 70%;"/>
                </div>
            </div>
        </div>

        <div style="width: 20%; float: left; border-right: 1px dotted #000; min-height: 200px">
            <div style="width: 100%;margin-top: 3%; text-align: center;">
                <img src="{{asset('user/images/logos/logo.png')}}" style="width: 90%;"/>
            </div>
            {{-- <div style="width: 100%; margin-top: 18%;  border-left: 1px dotted #000; text-align: center;">
                @if ($user->pass_id)
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($user->pass_id)) !!} "  style="width: 80%;">
            @else
                <p>No Pass ID available</p>
            @endif
            </div> --}}
            <div style="width: 100%; margin-top: 18%;  border-left: 1px dotted #000; text-align: center;">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($user_registration->pass_id)) !!} "  style="width: 80%;">
            </div>

        </div>

        <div style="width: 30%; float: right;">
            <div style="width: 95%; float: right;  font-size: 12px;">
                <p style="font-size: 50px; letter-spacing: 1px; word-spacing: 1px; color: #a91e24; text-align: center; margin: 10px 0px -25px 0px">
                    {{-- <b>{{isset($venue->event_date) ?  date('d', strtotime($venue->event_date)) : ''}}</b> --}}
                    <b style="padding-bottom: 10px">05-06</b>
                </p>
                {{-- <p style="margin-bottom: 15px; font-size: 16px; letter-spacing: 1px; word-spacing: 1px; text-align: center;"><b>{{isset($venue->event_date) ?  date('F', strtotime($venue->event_date)) : ''}}</b></p> --}}
                <p style="margin-bottom: 15px; font-size: 16px; letter-spacing: 1px; word-spacing: 1px; text-align: center;"><b>December</b></p>
                <div style="margin: -20px 0px 0px 0px">
                <p style="margin-bottom: -10px"><b>Time :</b> {{isset($venue->start_time) ? date('h:i A', strtotime($venue->start_time)) : ''}}</p>
                {{-- <p style="margin-bottom: -10px"><b>Registration #</b> : {{isset($user->reg_no) ? ucwords($user->reg_no) : ''}}</p> --}}
                <p style="margin-bottom: -10px"><b>Member</b> : {{isset($registration_type->name) ? ucwords($registration_type->name) : ''}}</p>
                <p>
                    @if(isset($user->seat_no))
                        <b>Seat :</b> {{isset($user->seat_no) ? ucwords($user->seat_no) : ''}}
                    @endif
                </p>
                </div>
                <p style="{{!isset($user->seat_no) ? 'margin-top:35px;' : ''}} text-align: center; font-size: 14px;">{{isset($venue->location) ? ucwords($venue->location) : ''}}</p>
            </div>
        </div>
    </div>
</div>

</div>
<p style="font-size: 10px; text-align: right; margin: 1px 10px 0px 0px">
    {{isset($user_registration->pass_id) ? $user_registration->pass_id : ''}}</p>
{{--{{die}}--}}
</body>
</html>
