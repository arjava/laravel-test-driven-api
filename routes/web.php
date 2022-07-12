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
    // return redirect($url);
    return $url;

});

Route::get('/google-drive/callback', function(){
    $client = new Client();
    $client->setClientId('633460834457-eedh0g6duhdu3817g0lihte05b1soh2v.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $code = request('code');
    $access_token = $client->fetchAccessTokenWithAuthCode($code);
    return $access_token;
});

Route::get('upload', function(){
    $client = new Client();
    $access_token = 'ya29.a0AVA9y1sJcgaQbvSxJ9hpq8ZQDYH6YD1M6afnfzmmoRMQ81w8IGcKkBbFmBT7kwCnMrUmDZsE2fBi5_O_rH14MpI3b23N0z9N2jTuiq_nSJlIsEmt5Gjn8ICAXoKS2mBr5ysKfNzWeel1ReRyR6QcKTiLayjA';

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

    $file->setName('Hahay Dunia');
    $service->files->create(
        $file,
        array(
            'data'=> file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        )
        );
});
