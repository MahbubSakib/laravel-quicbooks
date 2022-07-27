<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Authentication;
use App\Models\Contact;
use Auth;
use App\Traits\ApiResponser;
use App\Models\PersonalAccessToken;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $successStatus = 200;
    
    public function login(){ 

        if(Auth::attempt(['email' => request('email'),  'password' => request('password')]))
        { 

            $user = Auth::user(); 

            $token =  $user->createToken('devel')->plainTextToken; 
            return response()->json(['token' => $token], $this->successStatus); 
            // return response()->json(['token' => $token, 'user_id' => $userId, 'company_id' => $companyId], $this->successStatus); 
        } 
        else
        { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    
}
