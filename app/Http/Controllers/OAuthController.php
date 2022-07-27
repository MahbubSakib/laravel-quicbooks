<?php

namespace App\Http\Controllers;
// require('vendor/autoload.php');
// include('../config.php');
require "../vendor/autoload.php";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

class OAuthController extends Controller
{
    public function redirect()
    {
        $queries = http_build_query([
            'client_id' => 'Your client id',
            'scope' => 'com.intuit.quickbooks.accounting',
            'redirect_uri' => 'http://localhost:8000/oauth/callback',
            'response_type' => 'code',
            'state' => 'SHMRC',
            'baseUrl' => "development"
        ]);

        return redirect('https://appcenter.intuit.com/connect/oauth2?' . $queries);
    }

    public function callback(Request $request)
    {
        $client_id= 'Your client id';
        $client_secret= 'Your client secret';
        $header = 'Basic '. base64_encode($client_id.':'.$client_secret);
        // dd($header);
        $response = Http::withHeaders([
                                'Accept' => 'application/json',
                                'Authorization' => $header,
                                'Host'=> 'oauth.platform.intuit.com',
                                'Content-Type' => 'application/x-www-form-urlencoded'
                                ])->asForm()
                                ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                                    'redirect_uri' => 'http://localhost:8000/oauth/callback',
                                    'code'         => $request->code,
                                    'grant_type'   => 'authorization_code'
                                ]);

        $response = $response->json();
        // dd($request->realmId);

        $request->user()->token()->delete();

        // $ttt = $response->json();
        // dd($response);
        $request->user()->token()->create([
            'realm_id' => $request->realmId,
            'access_token' => $response['access_token'],
            'access_token_expires_at'   => $response['expires_in'],
            'refresh_token' => $response['refresh_token'],
            'refresh_token_expires_at'   => $response['x_refresh_token_expires_in'],
        ]);
        return redirect('/home');
    }
    // echo "<pre>";
    // print_r($invoice);

    public function refresh(Request $request)
    {
        // dd('ff');
        $client_id= 'Your client id';
        $client_secret= 'Your client secret';
        $header = 'Basic '. base64_encode($client_id.':'.$client_secret);
        // dd($header);
        $response = Http::withHeaders([
                                'Accept' => 'application/json',
                                'Authorization' => $header,
                                'Host'=> 'oauth.platform.intuit.com',
                                'Content-Type' => 'application/x-www-form-urlencoded'
                                ])->asForm()
                                ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                                    'redirect_uri' => 'http://localhost:8000/oauth/callback',
                                    // 'code'         => $request->code,
                                    'grant_type'   => 'refresh_token',
                                    'refresh_token' => $request->user()->token->refresh_token,
                                    'scope' => 'com.intuit.quickbooks.accounting'
                                ]);

        if ($response->status() !== 200) {
            $request->user()->token()->delete();

            return redirect('/home')
                ->withStatus('Authorization failed from OAuth server.');
        }

        $response = $response->json();
        // dd($request->realmId);
        $request->user()->token()->update([
            // 'realm_id' => $request->realmId,
            'access_token' => $response['access_token'],
            'access_token_expires_at'   => $response['expires_in'],
            'refresh_token' => $response['refresh_token'],
            'refresh_token_expires_at'   => $response['x_refresh_token_expires_in'],
        ]);
        return redirect('/oauth/invoice/index');
    }
}