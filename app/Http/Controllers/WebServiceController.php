<?php

namespace App\Http\Controllers;

use App\Models\WebService;
use Google\Client;
use Illuminate\Http\Request;

class WebServiceController extends Controller
{
    public const GOOGLE_DRIVE_SCOPES = ['https://www.googleapis.com/auth/drive',
    'https://www.googleapis.com/auth/drive.file'];

    public function connect($name, Client $client){

        if($name === 'google-drive'){
            // $client = new Client();
            // $config = config('services.google-drive');
            // $client->setClientId($config['id']);
            // $client->setClientSecret($config['secret']);
            // $client->setRedirectUri($config['redirect_url']);
            $client->setScopes(self::GOOGLE_DRIVE_SCOPES);
            $url = $client->createAuthUrl();
            return response(['url' => $url]);
        }
    }

    public function callback(Request $request, Client $client){

        $access_token = $client->fetchAccessTokenWithAuthCode($request->code);

        $service = WebService::create(['user_id' => auth()->id(),
        'token' => json_encode(['access_token' => $access_token]),
        'name' => 'google-drive']);
        return $service;

    }
}
