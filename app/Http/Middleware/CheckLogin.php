<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    use \App\Traits\Api\Response;
    public $data;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = $request->header('auth') ;
        if(!isset($auth)){
            $this->data=['status_code'=>401,
                "error"=>["Login token is incorrect"],
                'data'=>[]
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $loginVal = User::where('m_login_token', $auth)->where('status' , 1)->first();
        if(!isset($loginVal)){
            $this->data=['status_code'=>401,
                "error"=>["Login token is incorrect or User is in-active"],
                'data'=>[]
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        return $next($request);
    }
}
