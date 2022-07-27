<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;
use App\Models\Authentication;
use App\Models\Contact;
use App\Models\Usergroup;
use App\Models\Company;
use App\Models\CompanyCredit;
use App\Models\CompanyTrackingCode;
use App\Models\SystemLog;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Cache;
use App\Models\PersonalAccessToken;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Mail\OneTimeCodeMailable;

class UserController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('');

    }

}
