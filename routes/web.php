<?php

use Google\Client;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MimeTypes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/drive', function(){
    $client = new Client();
    $client->setClientId('633460834457-eedh0g6duhdu3817g0lihte05b1soh2v.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file'
    ]);
    $url = $client->createAuthUrl();
    return redirect($url);

});

Route::get('/google-drive/callback', function(){
    // $client = new Client();
    // $client->setClientId('633460834457-eedh0g6duhdu3817g0lihte05b1soh2v.apps.googleusercontent.com');
    // $client->setClientSecret('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');
    // $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    // $code = request('code');
    // $access_token = $client->fetchAccessTokenWithAuthCode($code);
    // return $access_token;
    return request('code');
});

Route::get('upload', function(){
    $client = new Client();
    $access_token = 'ya29.a0AVA9y1ut4gQ2uif469qIvP83Sz_VZ4ty9GByOnAti9MZo2ScgLbbOwSkp4E-hUHDp1JdLcSn8bFMyHkWcat7lot2NqRA2YD2DQA3DD9wOHCrwQQ2vpq3O-Hin7yAd8UMaI14bB0K2a-jsm3luofs44KatXCG';

    $client->setAccessToken($access_token);
    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    DEFINE("TESTFILE", 'test-file-small.txt');
    if(!file_exists(TESTFILE)){
        $fh = fopen(TESTFILE, 'w');
        fseek($fh,1024*1024);
        fwrite($fh, '!', 1);
        fclose($fh);
    }

    $file->setName('HahayDunia.zip');
    $service->files->create(
        $file,
        array(
            'data'=> file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        )
        );
    return response(['message'=>'Sukses Uploaded']);
});
