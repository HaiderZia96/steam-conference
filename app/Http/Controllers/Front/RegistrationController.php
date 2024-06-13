<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Module;
use App\Models\PaymentType;
use App\Models\StatusType;
use App\Models\RegistrationType;
use App\Models\ConferenceYear;
use App\Models\State;
use App\Models\User;
use App\Models\UserRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index(){
        return view('front.registration');
    }
    public function store(Request $request)
    {
        $conference = ConferenceYear::where('status', 1)->first();
        // dd(empty($session));
        if (empty($conference)) {
            $messages=[  array(
                'message' => 'Registration Close',
                'message_type' => 'error'
                )];
                 Session::flash('messages', $messages);
            //   dd(Session::flash('messages', $messages));
              return redirect()->back();
       }

       //Registration Status
       $status_type = StatusType::where('status_types.name', 'Not Submitted')->first();
    //    dd($status_type);
       if (empty($status_type)) {
           abort(404, 'NOT FOUND');
       }

        // dd('123');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'contact_no' => 'required|string|min:8|max:15',
            'qualification' => 'required',
            'title' => 'required',
            'payment' => 'required',
            'registration' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
        // assign user module
        $module_slug = 'user';
        //Module
        $module = Module::where('modules.slug', '=', $module_slug)->first();
        //User Data Array

        // dd($user);
        
         //Role
         
         $arr_reg = [
            'title' => $request->title,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'contact_no' => $request->contact_no,
           
            'payment_type_id' => $request->payment,
            'registration_type_id' => $request->registration,
            'qualification' => $request->qualification,
            'conference_year_id' => $conference->id,
            'status_type_id' => $status_type->id,
            'pass_id' => 'c_' . Str::uuid()->toString(),
        ];
       
        $registrationRecord = UserRegistration::create($arr_reg);


        if($registrationRecord == true){
        $arr = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'module_id' => $module->id,
        ];

        $user = User::create($arr);

        if ($user) {
            // If $user is successfully created, proceed to store $arr1
            $role = Role::where('roles.name', '=', 'user')->first();

            $user->assignRole($role->name);

            $arr5 = [
                'user_id' => $user->id
            ];

            $registrationRecord->update($arr5);
    
            $messages = [
                array(
                    'message' => 'Record created successfully',
                    'message_type' => 'success'
                ),
            ];
            Session::flash('messages', $messages);
        } else {
            // If $user creation fails, delete the $registrationRecord record
            $registrationRecord->delete();
    
            $messages = [
                array(
                    'message' => 'Failed to create user record',
                    'message_type' => 'error'
                )
            ];
            Session::flash('messages', $messages);
        }






        $payment = PaymentType::where('payment_types.id', $request->input('payment'))->first();
        // dd($payment);
        if (empty($payment)) {
            abort(404, 'NOT FOUND');
        } else if ($payment->id == 2) {
            $messages = [
                array(
                    'message' => 'You can register as a Walk-in candidate on Conference day.',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);
            return redirect()->back();
        }
        if (!$registrationRecord) {
            // If $registrationRecord creation fails, delete the $user record
            $user->delete();

            $messages = [
                array(
                    'message' => 'Failed to create user registration record',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);

            return redirect()->back();
        }
        event(new Registered($user));

        Auth::login($user);

        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);
    } else {
        $messages = [
            array(
                'message' => 'Failed to create user record',
                'message_type' => 'error'
            ),
        ];
        Session::flash('messages', $messages);
    }

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->intended(url('admin/dashboard'));


}
/**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /** This Function is used to Fetch Countries in Select list **/
    public function getCountryIndexSelect(Request $request)
    {
        // $data = [];
        // if($request->has('q')){
            $search = $request->q;

            $data = Country::where('name', 'like', '%' .$search . '%')
                ->get();
        // }

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /** This Function is used to Fetch States based on Countries in Select list **/
    public function getStateIndexSelect(Request $request)
    {
        // $data = [];
        // if($request->has('q')){
            $search = $request->q;
            $countryId = $request->countryId;

            $data = State::where('country_id',$countryId)
                ->where('name', 'like', '%' .$search . '%')
                ->get();
        // }

        return response()->json($data);
    }
     /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /** This Function is used to Fetch City based on Countries & States in Select list **/
    public function getCityIndexSelect(Request $request)
    {
        // $data = [];
        // if($request->has('q')){
            $search = $request->q;
            $countryId = $request->countryId;
            $stateId = $request->stateId;

            $data = City::where('country_id',$countryId)
                ->where('state_id',$stateId)
                ->where('name', 'like', '%' .$search . '%')
                ->get();
        // }

        return response()->json($data);
    }
    public function getIndexPaymentTypeSelect(Request $request)
    {
        // $data = [];

        // if($request->has('q')){
            $search = $request->q;
            $data = PaymentType::with('user_registrations','users')
                ->where('payment_types.name', 'like', '%' .$search . '%')
                ->get();
        // }

        return response()->json($data);

    }
    public function getIndexRegistrationTypeSelect(Request $request)
    {
        // $data = [];

        // if($request->has('q')){
            $search = $request->q;
            $data = RegistrationType::select('registration_types.id as id','registration_types.name as name')
                ->where(function ($q) use ($search){
                    $q->where('registration_types.name', 'like', '%' .$search . '%');
                })
                ->get();
        // }

        return response()->json($data);

    }

}
