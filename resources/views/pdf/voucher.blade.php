<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Challan Form</title>

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

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        img {
            width: 90%;
        }

        .main-table {
            width: 100%;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            color: #000;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .personalInfo table {
            border-collapse: collapse;
        }

        .personalInfo table tr td {
            border: 1px solid black;
        }

        tr {
            margin-bottom: 5px;
        }

        .heading {
            background-color: #c2c2c2;
            padding: 3px 10px;
        }

        .feeTable {
            border-collapse: collapse;
            width: 100%;
            padding: 0;
        }

        .feeTable tbody {
            height: 350px
        }

        .feeTable tr th, .feeTable tr td {
            border: 1px solid #000;
            font-size: 10px;
        }

        .small {
            font-size: 10px;
        }

        .bold {
            font-size: 8px;
            font-weight: bold;
        }

        .border-bottom {
            border: 0;
            border-bottom: 1px solid #000000;
            width: 70%;
            font-weight: bold;
            font-size: 9px;
        }

        .border-bottom-full {
            border: 0;
            border-bottom: 1px solid #000000;
            width: 80%;
            font-weight: bold;
            font-size: 9px;
        }

        .reg-border {
            border: 0;
            border-bottom: 1px solid #000000;
            width: 60%;
            font-weight: bold;
            font-size: 9px;
        }

        input {
            outline: 0;
            border-width: 0 0 2px;
            border-color: #000
        }
    </style>

</head>
<body>

<div class="information">
    <table class="main-table">
        <tr>
            <td style="width: 34%; border-right: 1px dotted #000;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" align="center" class="bold"><img style="width: 35%;" src="{{asset('front/coreui/images/tuf_logo.png')}}" alt="logo"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="feeTable" style="border: none">
                                <thead>
                                <tr>
                                    <th colspan="2" style=" border:none;">Bank</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 4px ; border: none; font-weight: bold">Bank Name:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->bank_name}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold">Branch Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->branch_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Swift Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->swift_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account
                                        Title:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_title}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account #:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> IBAN #:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->iban_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Country:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->country_no}}</td>
                                </tr>

                                </tbody>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td><label class="small">Due Date:</label><input type="text" class="border-bottom"
                                                                         value="{{$voucher->last_date}}"
                                                                         style="width: 100px;margin-top: 10px;">
                        </td>
                        <td><label class="small">Challan#:</label><input type="text" class="border-bottom"
                                                                         value="{{$voucher->challan_no}}"
                                                                         style="width: 100px;margin-top: 10px;">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><label class="small">Name:</label><input type="text" class="border-bottom-full"
                                                                                 value="{{$voucher->name}}">
                        </td>
                    </tr>
                    <tr style="margin-top: -10px">
                        <td colspan="2"><label class="small">Email:</label><input type="text"
                                                                                  class="border-bottom-full"
                                                                                  value="{{$voucher->email}}"
                                                                                  style="width: 130px;margin-top: 10px;">
                        </td>
                    </tr>

                    {{--                    <tr>--}}
                    {{--                        <td colspan="2"><label class="small">Cash/Chq/DD:</label><input type="text"--}}
                    {{--                                                                                        class="border-bottom"--}}
                    {{--                                                                                        value="{{$voucher->voucher_type}}"--}}
                    {{--                                                                                        style="width: 130px;margin-top: 10px;">--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                    <tr>
                        <td colspan="2">
                            <table class="feeTable">
                                <thead>
                                <tr>
                                    <th style="width: 20px">S.No</th>
                                    <th style="width: 130px">Head of A/C</th>
                                    <th style="width: 50px">Amount</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($voucherHead as $key=> $head)
                                    <tr>
                                        <td style="padding:3px 13px 3px 5px">{{$key+1}}</td>
                                        <td style="padding:3px 13px 3px 5px">{{$head->head}}</td>
                                        <td style="text-align: center">
                                            @if($user_registration->country_id != 167)
                                                $
                                            @endif
                                            {{$head->amount}}
                                            @if($user_registration->country_id == 167)
                                                PKR
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                                <tr>
                                    <td colspan="3"><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Grand Total</td>
                                    <td align="right">
                                        @if($user_registration->country_id != 167)
                                            $
                                        @endif
                                        {{$grand_total}}
                                        @if($user_registration->country_id == 167)
                                            PKR
                                        @endif
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bold">Amount In Words: <u><b></b></u></td>
                    </tr>
                    <tr>
                        <td class="bold">{{$amount_words}}
                            @if($user_registration->country_id != 167)
                                Dollars only
                            @endif
                            @if($user_registration->country_id == 167)
                                Rupees only
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">(Valid Till Mentioned Date)</td>
                    </tr>
                    <tr>
                        <td colspan="2"><br><br></td>
                    </tr>
                    <tr>
                        <td class="bold">Depositer's Signature</td>
                        <td class="bold">Office Stamp / Signature</td>
                    </tr>

                    <tr>
                        <td class="bold">Bank Copy</td>
                    </tr>
                </table>
            </td>
            <td style="width: 34%; border-right: 1px dotted #000;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" align="center" class="bold"><img style="width: 35%;" src="{{asset('front/coreui/images/tuf_logo.png')}}" alt="logo"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="feeTable" style="border: none">
                                <thead>
                                <tr>
                                    <th colspan="2" style=" border:none;">Bank</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 0px ; border: none; font-weight: bold">Bank Name:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->bank_name}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold">Branch Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->branch_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Swift Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->swift_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account
                                        Title:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_title}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account #:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> IBAN #:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->iban_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Country:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->country_no}}</td>
                                </tr>

                                </tbody>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td><label class="small">Due Date:</label><input type="text" class="border-bottom"
                                                                     value="{{$voucher->last_date}}"
                                                                     style="width: 100px;margin-top: 10px;">
                        </td>
                        <td><label class="small">Challan#:</label><input type="text" class="border-bottom"
                                                                         value="{{$voucher->challan_no}}"
                                                                         style="width: 100px;margin-top: 10px;">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><label class="small">Name:</label><input type="text" class="border-bottom-full"
                                                                                 value="{{$voucher->name}}">
                        </td>
                    </tr>
                    <tr style="margin-top: -10px">
                        <td colspan="2"><label class="small">Email:</label><input type="text"
                                                                                  class="border-bottom-full"
                                                                                  value="{{$voucher->email}}"
                                                                                  style="width: 130px;margin-top: 10px;">
                        </td>
                    </tr>

                    {{--                    <tr>--}}
                    {{--                        <td colspan="2"><label class="small">Cash/Chq/DD:</label><input type="text"--}}
                    {{--                                                                                        class="border-bottom"--}}
                    {{--                                                                                        value="{{$voucher->voucher_type}}"--}}
                    {{--                                                                                        style="width: 130px;margin-top: 10px;">--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                    <tr>
                        <td colspan="2">
                            <table class="feeTable">
                                <thead>
                                <tr>
                                    <th style="width: 20px">S.No</th>
                                    <th style="width: 130px">Head of A/C</th>
                                    <th style="width: 50px">Amount</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($voucherHead as $key=> $head)
                                    <tr>
                                        <td style="padding:3px 13px 3px 5px">{{$key+1}}</td>
                                        <td style="padding:3px 13px 3px 5px">{{$head->head}}</td>
                                        <td style="text-align: center">
                                            @if($user_registration->country_id != 167)
                                                $
                                            @endif
                                            {{$head->amount}}
                                            @if($user_registration->country_id == 167)
                                                PKR
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                                <tr>
                                    <td colspan="3"><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Grand Total</td>
                                    <td align="right">
                                        @if($user_registration->country_id != 167)
                                            $
                                        @endif
                                        {{$grand_total}}
                                        @if($user_registration->country_id == 167)
                                            PKR
                                        @endif
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bold">Amount In Words: <u><b></b></u></td>
                    </tr>
                    <tr>
                        <td class="bold">{{$amount_words}}
                            @if($user_registration->country_id != 167)
                                Dollars only
                            @endif
                            @if($user_registration->country_id == 167)
                                Rupees only
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">(Valid Till Mentioned Date)</td>
                    </tr>
                    <tr>
                        <td colspan="2"><br><br></td>
                    </tr>
                    <tr>
                        <td class="bold">Depositer's Signature</td>
                        <td class="bold">Office Stamp / Signature</td>
                    </tr>

                    <tr>
                        <td class="bold">Applicant Copy</td>
                    </tr>
                </table>
            </td>
            <td style="width: 34%; border-right: 1px dotted #000;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" align="center" class="bold"><img style="width: 35%;" src="{{asset('front/coreui/images/tuf_logo.png')}}" alt="logo"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="feeTable" style="border: none">
                                <thead>
                                <tr>
                                    <th colspan="2" style=" border:none;">Bank</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 0px ; border: none; font-weight: bold">Bank Name:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->bank_name}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold">Branch Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->branch_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Swift Code:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->swift_code}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account
                                        Title:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_title}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Account #:
                                    </td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->account_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> IBAN #:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->iban_no}}</td>
                                </tr>
                                <tr style="border-bottom: 1px dotted #000">
                                    <td style="padding:3px 3px 3px 3px ; border: none; font-weight: bold"> Country:</td>
                                    <td style="padding:3px 13px 3px 5px ; border: none">{{$voucher->country_no}}</td>
                                </tr>

                                </tbody>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 1px solid #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"></td>
                    </tr>
                    <tr>
                        <td><label class="small">Due Date:</label><input type="text" class="border-bottom"
                                                                     value="{{$voucher->last_date}}"
                                                                     style="width: 100px;margin-top: 10px;">
                        </td>
                        <td><label class="small">Challan#:</label><input type="text" class="border-bottom"
                                                                         value="{{$voucher->challan_no}}"
                                                                         style="width: 100px;margin-top: 10px;">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><label class="small">Name:</label><input type="text" class="border-bottom-full"
                                                                                 value="{{$voucher->name}}">
                        </td>
                    </tr>
                    <tr style="margin-top: -10px">
                        <td colspan="2"><label class="small">Email:</label><input type="text"
                                                                                  class="border-bottom-full"
                                                                                  value="{{$voucher->email}}"
                                                                                  style="width: 130px;margin-top: 10px;">
                        </td>
                    </tr>

                    {{--                    <tr>--}}
                    {{--                        <td colspan="2"><label class="small">Cash/Chq/DD:</label><input type="text"--}}
                    {{--                                                                                        class="border-bottom"--}}
                    {{--                                                                                        value="{{$voucher->voucher_type}}"--}}
                    {{--                                                                                        style="width: 130px;margin-top: 10px;">--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
                    <tr>
                        <td colspan="2">
                            <table class="feeTable">
                                <thead>
                                <tr>
                                    <th style="width: 20px">S.No</th>
                                    <th style="width: 130px">Head of A/C</th>
                                    <th style="width: 50px">Amount</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($voucherHead as $key=> $head)
                                    <tr>
                                        <td style="padding:3px 13px 3px 5px">{{$key+1}}</td>
                                        <td style="padding:3px 13px 3px 5px">{{$head->head}}</td>
                                        <td style="text-align: center">
                                            @if($user_registration->country_id != 167)
                                                $
                                            @endif
                                            {{$head->amount}}
                                            @if($user_registration->country_id == 167)
                                                PKR
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                                <tr>
                                    <td colspan="3"><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Grand Total</td>
                                    <td align="right">
                                        @if($user_registration->country_id != 167)
                                            $
                                        @endif
                                        {{$grand_total}}
                                        @if($user_registration->country_id == 167)
                                            PKR
                                        @endif
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bold">Amount In Words: <u><b></b></u></td>
                    </tr>
                    <tr>
                        <td class="bold">{{$amount_words}}
                            @if($user_registration->country_id != 167)
                                Dollars only
                            @endif
                            @if($user_registration->country_id == 167)
                                Rupees only
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">(Valid Till Mentioned Date)</td>
                    </tr>
                    <tr>
                        <td colspan="2"><br><br></td>
                    </tr>
                    <tr>
                        <td class="bold">Depositer's Signature</td>
                        <td class="bold">Office Stamp / Signature</td>
                    </tr>

                    <tr>
                        <td class="bold">Finance Copy</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
