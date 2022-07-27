<?php

namespace App\Http\Controllers;
require "../vendor/autoload.php";
use App\Models\Invoise;
use App\Models\OauthToken;
use Illuminate\Http\Request;

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Line;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTime;

class InvoiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // $value = '3600';
        // $dt = Carbon::now();
        // $hours = $dt->diffInHours($dt->copy()->addSeconds($value));
        // $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($value)->subHours($hours));
        // // $ss = CarbonInterval::hours($hours)->minutes($minutes)->forHumans();
        // $ss = date("Y-m-d H:i:s", 1388516402);;
        // dd($ss);


        $accessToken = auth()->user()->token['access_token'];
        $refreshToken = auth()->user()->token['refresh_token'];
        $realmId = auth()->user()->token['realm_id'];
        // dd($ff);
        if (auth()->user()->token) {

            if (auth()->user()->token->hasExpired()) {
                return redirect('/oauth/refresh');
            }
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => "Your client id",
                'ClientSecret' => "Your client secert",
                'accessTokenKey' => $accessToken,
                'refreshTokenKey' => $refreshToken,
                'QBORealmID' => $realmId,
                'baseUrl' => "Development"
            ));
            //Add a new Invoice
            
            $invoice = $dataService->Query("SELECT * FROM Invoice");
            // echo "<pre>";
            // print_r($invoice);
            $error = $dataService->getLastError();
            if ($error) {
                echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                echo "The Response message is: " . $error->getResponseBody() . "\n";
            }
            else {
                // echo "Created Id={$invoice[1]->Id}";
                // $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($invoice, $urlResource);
                // echo $xmlBody . "\n";
            }

            return view('invoise.index', compact('invoice'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoise.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accessToken = auth()->user()->token['access_token'];
        $refreshToken = auth()->user()->token['refresh_token'];
        $realmId = auth()->user()->token['realm_id'];

        
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => "Your client id",
            'ClientSecret' => "Your client secret",
            'accessTokenKey' => $accessToken,
            'refreshTokenKey' => $refreshToken,
            'QBORealmID' => $realmId,
            'baseUrl' => "Development"
        ));

        // $data = $request->all();
        // dd($data);

        $theResourceObj = Invoice::create([

            "Line" => [
                [
                  "DetailType"=> $request->input('DetailType'), 
                  "Amount"=> $request->input('Amount'), 
                  "SalesItemLineDetail"=> [
                    "ItemRef"=> [
                      "value"=> $request->input('value')
                  ]
                ]
                ]
              ], 
              "CustomerRef"=> [
                "value"=> $request->input('value2')
              ]

            
        ]);
        // dd($theResourceObj);
        $resultingObj = $dataService->Add($theResourceObj);
        $error = $dataService->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
        }
        else {
            echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
            $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
            echo $xmlBody . "\n";
        }
        return redirect('/home');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoise  $invoise
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoise  $invoise
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoise $invoise, $id)
    {
        $accessToken = auth()->user()->token['access_token'];
        $refreshToken = auth()->user()->token['refresh_token'];
        $realmId = auth()->user()->token['realm_id'];
        // dd($ff);
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => "Your client id",
            'ClientSecret' => "Your client secret",
            'accessTokenKey' => $accessToken,
            'refreshTokenKey' => $refreshToken,
            'QBORealmID' => $realmId,
            'baseUrl' => "Development"
        ));
        
        $invoice = $dataService->findById("invoice", $id);
        // dd($invoice);
        // echo "<pre>";
        // print_r($invoice);

        return view('invoise.update', compact('invoice'));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoise  $invoise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $accessToken = auth()->user()->token['access_token'];
        $refreshToken = auth()->user()->token['refresh_token'];
        $realmId = auth()->user()->token['realm_id'];

        
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => "Your client id",
            'ClientSecret' => "Your client secret",
            'accessTokenKey' => $accessToken,
            'refreshTokenKey' => $refreshToken,
            'QBORealmID' => $realmId,
            'baseUrl' => "Development"
        ));

        // $data = $request->all();
        // dd($data);
        $invoice = $dataService->FindbyId('invoice', $id);
        // dd($invoice);

        $theResourceObj = Invoice::update($invoice, [

            "Line" => [
                [
                  "DetailType"=> $request->input('DetailType'), 
                  "Amount"=> $request->input('Amount'), 
                  "SalesItemLineDetail"=> [
                    "ItemRef"=> [
                      "value"=> $request->input('value')
                  ]
                ]
                ]
              ], 
              "CustomerRef"=> [
                "value"=> $request->input('value2')
              ]

            
        ]);
        // dd($theResourceObj);
        $resultingObj = $dataService->Add($theResourceObj);
        $error = $dataService->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
        }
        else {
            echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
            $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
            echo $xmlBody . "\n";
        }
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoise  $invoise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoise $invoise, $id)
    {
        $accessToken = auth()->user()->token['access_token'];
        $refreshToken = auth()->user()->token['refresh_token'];
        $realmId = auth()->user()->token['realm_id'];
        // dd($ff);
        if (auth()->user()->token) {

            if (auth()->user()->token->hasExpired()) {
                return redirect('/oauth/refresh');
            }
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => "Your client id",
                'ClientSecret' => "Your client secret",
                'accessTokenKey' => $accessToken,
                'refreshTokenKey' => $refreshToken,
                'QBORealmID' => $realmId,
                'baseUrl' => "Development"
            ));

            $invoice = $dataService->FindbyId('invoice', $id);
            $resultingObj = $dataService->Delete($invoice);
            $error = $dataService->getLastError();
            if ($error) {
                echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                echo "The Response message is: " . $error->getResponseBody() . "\n";
            }
            else {
                echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
                $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
                echo $xmlBody . "\n";
            }
        }
        return redirect()->back();
    }
}
