<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\CertificatePDF;
use App\Models\RegistrationType;
use App\Models\ConferenceYear;
use App\Models\User;
use App\Models\Venue;
use App\Models\UserRegistration;
use App\Models\VoucherPDF;
use App\Models\VoucherPDFHead;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Response;

class RegistrationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user_registration_user-registration-list', ['only' => ['index', 'getIndex']]);
    }

    public function index()
    {
        //Data Array
        $data = array(
            'page_title' => 'Registration',
            'p_title' => 'Registration',
            'p_summary' => '',
            'p_description' => null,
            // 'data' => $uid->id,
        );

        return view('user.registration.userRegistration.index')->with($data);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        # Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        // $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        // $columnIndex = $columnIndex_arr[0]['column']; // Column index
        // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        //Add Filters
        $where = [];

        if (!empty($request->get('user_id'))) {
            $user = $request->get('user_id');
            $var = ['user_registrations.user_id', '=', $user];
            array_push($where, $var);
        } elseif (!empty($request->get('user_id'))) {
            $user = $request->get('user_id');
            $var = ['user_registrations.user_id', '=', $user];
            array_push($where, $var);
        }
        if (!empty($request->get('registration_type_id'))) {
            $registration_type = $request->get('registration_type_id');
            $var = ['user_registrations.registration_type_id', '=', $registration_type];
            array_push($where, $var);
        }

        if (!empty($request->get('module_id'))) {
            $module = $request->get('module_id');
            $var = ['user_registrations.module_id', '=', $module];
            array_push($where, $var);
        }

        if (!empty($request->get('conference_year_id'))) {
            $conference_year = $request->get('conference_year_id');
            $var = ['user_registrations.conference_year_id', '=', $conference_year];
            array_push($where, $var);
        } elseif (!empty($request->get('sid'))) {
            // Use the 'sid' parameter to filter by conference_year ID
            $conference_year = $request->get('sid');
            $var = ['user_registrations.conference_year_id', '=', $conference_year];
            array_push($where, $var);
        }

        if (!empty($request->get('status_type_id'))) {
            $status_type = $request->get('status_type_id');
            $var = ['user_registrations.status_type_id', '=', $status_type];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name', 'modules.name as module_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('modules', 'modules.id', '=', 'users.module_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->where('user_id', Auth::user()->id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name', 'modules.name as module_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('modules', 'modules.id', '=', 'users.module_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->where('user_id', Auth::user()->id)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('modules.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('conference_years.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name', 'modules.name as module_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('modules', 'modules.id', '=', 'users.module_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->where('user_id', Auth::user()->id)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('modules.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('conference_years.name', 'like', '%' . $searchValue . '%');
            })
            // ->skip($start)
            // ->take($rowperpage)
            // ->orderBy($columnName, $columnSortOrder)
            ->get();
// dd($records);
        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $email = $record->email;
            $conference_year_name = $record->conference_year_name;
            $module_name = $record->module_name;
            $registration_type_name = $record->registration_type_name;
            $voucher_upload = $record->voucher_upload;
            $status_type_name = $record->status_type_name;
            $attendee_status = $record->attendee_status;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "conference_year_name" => $conference_year_name,
                "module_name" => $module_name,
                "registration_type_name" => $registration_type_name,
                "voucher_upload" => $voucher_upload,
                "status_type_name" => $status_type_name,
                "attendee_status" => $attendee_status,

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        // dd($response);
        echo json_encode($response);
        exit;
    }

    public function editStatus(string $id)
    {
        $record = UserRegistration::select('user_registrations.*', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where('user_registrations.id', '=', $id)
            ->first();
        // dd($record);
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Registration Status',
            'p_title' => 'Registration Status',
            'p_summary' => 'Edit Status',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('user.get.user-registration-status', $record->id),
            'url' => route('user.user-registration'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('user.registration.userRegistration.status')->with($data);
    }

    public function voucher($id)
    {

        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();
        $registration_types = RegistrationType::where('id', $user_registration->registration_type_id)
            ->orderBy('id', 'desc')
            ->first();
        $conference_years = ConferenceYear::where('id', $user_registration->conference_year_id)->first();
        $voucher = VoucherPDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
            if ($voucher) {
                $voucher->update(['name' => $user->name, 'email' => $user->email]);
            }
        

//        if voucher record is not stored then store record and download voucher
        if (!isset($voucher)) {
            $arr = [
                'user_id' => $user->id,
                'conference_year_id' => $conference_years->id,
                'registration_type_id' => $registration_types->id,
                'user_registration_id' => $user_registration->id,
                // 'bank_name' => 'Habib Metropolitan Bank Limited',
                'bank_name' => 'Habib Metropolitan Bank Limited',
                'branch_code' => '1208',
                'swift_code' => 'MPBLPKKA',
                // 'branch_code' => '',
                // 'swift_code' => '',
                'account_title' => 'University of Faisalabad (Amin)',
                'account_no' => '6-12-08-20311-714-100031',
                'iban_no' => 'PK32MPBL1208027140100031',
                'country_no' => 'Pakistan',
                'last_date' => '06/12/2023',
                // 'bank_name' => '',
                // 'branch_code' => '',
                // 'swift_code' => '',
                // 'account_title' => '',
                // 'account_no' => '',
                // 'iban_no' => '',
                // 'country_no' => 'Pakistan',
                // 'last_date' => '',
                'challan_no' => random_int(1000000000, 9999999999),
                'name' => $user->name,
                'email' => $user->email,
                'voucher_type' => 'cash'
            ];


            $voucherPdf = VoucherPDF::create($arr);

            if ($voucherPdf) {
                if ($user_registration->country_id == 167) {
                    $voucherHeadStore['voucher_pdf_id'] = $voucherPdf->id;
                    $voucherHeadStore['head'] = $registration_types->name;
                    $voucherHeadStore['amount'] = $registration_types->fee;
                    VoucherPDFHead::create($voucherHeadStore);
                } else {
                    $voucherHeadStore['voucher_pdf_id'] = $voucherPdf->id;
                    $voucherHeadStore['head'] = $registration_types->name;
                    $voucherHeadStore['amount'] = $registration_types->international_fee;
                    VoucherPDFHead::create($voucherHeadStore);
                }
            }
        } else {
// dd($voucher);
            $arr = [
                'user_id' => $voucher->user_id,
                'conference_year_id' => $voucher->conference_year_id,
                'registration_type_id' => $registration_types->id,
                'user_registration_id' => $voucher->user_registration_id,
                'bank_name' => 'Habib Metropolitan Bank Limited',
                'branch_code' => '1208',
                'swift_code' => 'MPBLPKKA',
                'account_title' => 'The University of Faisalabad Main Account',
                'account_no' => '6-12-8-20311-714-100031',
                'iban_no' => 'PK32MPBL1208027140100031',
                'country_no' => 'Pakistan',
                'last_date' => '06/12/2023',
                'challan_no' => $voucher->challan_no,
                'name' => $voucher->name,
                'email' => $voucher->email,
                'voucher_type' => 'cash'
            ];

            $voucherPdf = $voucher->update($arr);
        //    dd($voucher->id);
        
           $voucherHead = VoucherPDFHead::where('voucher_pdf_id',$voucher->id)->first();
            if ($voucherPdf) {
                if ($user_registration->country_id == 167) {
                    $arr1 = [
                        'voucher_pdf_id' => $voucherHead->voucher_pdf_id,
                        'head' => $registration_types->name,
                        'amount' => $registration_types->fee
                    ];
                    $voucherHead->update($arr1);

                } else {
                    $arr1 = [
                        'voucher_pdf_id' => $voucherHead->voucher_pdf_id,
                        'head' => $registration_types->name,
                        'amount' => $registration_types->international_fee
                    ];
                    // dd($arr1);
                    $voucherHead->update($arr1);
                }
                // dd($voucherHead);
            }
          
        }

        $voucher = VoucherPDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
            // dd($voucher);

        $voucherHead = VoucherPDFHead::select('voucher_pdf_fee_head.*')
            ->leftjoin('voucher_pdf', 'voucher_pdf.id', '=', 'voucher_pdf_fee_head.voucher_pdf_id')
            ->where('voucher_pdf.user_registration_id', $id)->get();
            // dd($voucherHead);

        $grand_total = 0;
        foreach ($voucherHead as $total_amount) {
            $grand_total += $total_amount->amount;
        }
        $amount_words = $this->numberToWord($grand_total);
         // dd($voucherHead);
        $pdf = PDF::loadView('pdf.voucher', compact('voucher', 'voucherHead', 'grand_total', 'amount_words', 'user_registration'));
        $pdf->setPaper('A4', 'landscape');
        $name = $voucher->name;
        return $pdf->download("$name-" . $voucher->id . '.pdf');

    }

    public
    function numberToWord($num = '')
    {
        $num = ( string )(( int )$num);

        if (( int )($num) && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

            $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred');

            $list3 = array('', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion');

            $num_length = strlen($num);
            $levels = ( int )(($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = ( int )($num_part / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens = ( int )($num_part % 100);
                $singles = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = ( int )($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = ( int )($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!(( int )$num)) {
            return 'Zero';
        }
        return '';
    }

    public function upload(Request $request, $id)
    {
        $user_registration = UserRegistration::findOrFail($id);

        try {
            $this->validate($request, [
                'voucher_upload' => 'required|mimes:jpg,png,jpeg,pdf',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $messages = [
                [
                    'message' => 'Only .pdf, .jpg, .png, .jpeg format are allowed.',
                    'message_type' => 'error'
                ]
            ];

            return redirect()->back()->with('messages', $messages);
        }

        $uploadedFile = $request->file('voucher_upload');
        $uploadedFileOriginalName = $uploadedFile->getClientOriginalName();
        $fileName = pathinfo($uploadedFileOriginalName, PATHINFO_FILENAME);
        $extension = $request->file('voucher_upload')->extension();
        $folderPath = 'user/voucher/';
        $filename = date('Y') . '/' . date('m') . '/' . date('d') . '/' . time() . '-' . rand(0, 999999) . $fileName . '.' . $extension;
        $file = $folderPath . $filename;
        Storage::disk('private')->put($file, file_get_contents($uploadedFile->getRealPath()));

        $arr = [
            'voucher_upload' => $filename,
            'updated_by' => Auth::user()->id,
        ];

        $user_registration['status_type_id'] = 1;
        $user_registration->update($arr);
        $messages = [
            array(
                'message' => 'Voucher Uploaded successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect(url('user/user-registration'));

    }

    public function getImage($id)
    {
        $record = UserRegistration::where('id', '=', $id)->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $path = Storage::disk('private')->path('user/voucher/' . $record->voucher_upload);
        if (File::exists($path)) {
            // dd($path);
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else {
            abort(404, 'NOT FOUND');
        }

    }

    public function gatePass($id)
    {
        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();
        $registration_type = RegistrationType::where('id',$user_registration->registration_type_id)->first();
        $venue = Venue::Where('conference_year_id', $user_registration->conference_year_id)->first();
        $usersCount = User::where('id', $user_registration->user_id)->where('name', '!=', '')->count();
        $pdf = PDF::loadView('pdf.gate_pass', compact('user_registration', 'user', 'usersCount','venue','registration_type'));
        $pdf->setPaper('A4', 'portrait');
        $name = $user->name;
        return $pdf->download("$name-" . $user_registration->id . '.pdf');
    }
    public function certificate($id)
    {

        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();

        $sessions = ConferenceYear::where('id', $user_registration->conference_year_id)->first();

        $certificate = CertificatePDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();


//        if certificate record is not stored then store record and download certificate
        if (!isset($certificate)) {
            $arr = [
                'user_id' => $user->id,
                'user_registration_id' => $user_registration->id,
                'conference_year_id' => $sessions->id,
                'issue_date' => '12/07/2023',
                'start_date' => '12/05/2023',
                'end_date' => '12/06/2023',
                'title' => $user_registration->title,
                'name' => $user->name,
                'event_name' => '1st International Conference on Advance STEAM Education',
                'venue' => 'The University of Faisalabad',
            ];

            CertificatePDF::create($arr);

        } else {

            $arr = [
                'user_id' => $user->id,
                'user_registration_id' => $user_registration->id,
                'conference_year_id' => $sessions->id,
                'issue_date' => '12/07/2023',
                'start_date' => '12/05/2023',
                'end_date' => '12/06/2023',
                'title' => $user_registration->title,
                'name' => $user->name,
                'event_name' => '1st International Conference on Advance STEAM Education',
                'venue' => 'The University of Faisalabad',
            ];

            $certificate->update($arr);
        }

        $certificate = CertificatePDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();

        
        $pdf = PDF::loadView('pdf.certificate', compact('certificate',  'user_registration'));
        $pdf->setPaper('A4', 'landscape');
        $name = $certificate->name;
        Storage::disk('private')->put('user/certificate/' . $name . '-' . $user_registration->id . '.pdf', $pdf->download("$name-" . $user_registration->id . '.pdf'));
        return $pdf->download("$name-" . $certificate->id . '.pdf');

    }
}
