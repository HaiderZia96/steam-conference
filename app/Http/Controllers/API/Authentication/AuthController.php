<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use App\Models\ConferenceYear;
use App\Models\User;
use App\Traits\Api\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Response;

    public $data;

    public function login(Request $request)
    {
        if (!isset($request->event_id)){
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "error" => ["Event field is required"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        $credentials = $request->all('email','password');

        $userEmail = trim($request->email);

        $user = User::where('email', $userEmail)->first();
        if (empty($user)) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "error" => ["Invalid Credentials"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        if ($user->status != 1) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "info" => ["Your Account is not Active"],
                'data' => []
            ];

            $this->setResponse($this->data);
            return $this->getResponse();
        }
        if ($user->email_verified_at == null) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "info" => ["Please verify your email"],
                'data' => []
            ];

            $this->setResponse($this->data);
            return $this->getResponse();
        }

        if (auth()->attempt($credentials)) {

            $user = auth()->user();
            $user->last_login = Carbon::now();

            $auth_token = bin2hex(random_bytes(12));
            $user->m_login_token = $auth_token;
            $user->save();

            $event_id= ConferenceYear::where('status',1)->first();
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "success" => ["Login Successfully"],
                'data' => [
                    [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                        "event_id" => $event_id->id,
                        "event_name" => $event_id->name,
                        "last_login" => $user->last_login,
                        "auth_token" => $auth_token
                    ]
                ]
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
            "error" => ["Invalid Credentials"],
            'data' => []
        ];
        $this->setResponse($this->data);
        return $this->getResponse();

    }

    public function logout(Request $request)
    {
        $userEmail = trim($request->email);
        $user = User::where('email', $userEmail)->first();
        if (empty($user)) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "error" => ["User doesn't not exist"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $auth_token = null;
        $user->m_login_token = $auth_token;

        $user->save();

        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Logout Successfully."],
            'data' => [
                'email' => $userEmail
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function userDetail($token)
    {
        $users = User::where('m_login_token', $token)->first();
        if (!isset($users)) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "error" => ["Invalid Login Token"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        $profile = route('profile.get.image', $users->id);
        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Success"],
            'data' => [
                'email' => $users->email,
                'name' => $users->name,
                'last_login' => $users->last_login,
                'profile' => $profile,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }
}
