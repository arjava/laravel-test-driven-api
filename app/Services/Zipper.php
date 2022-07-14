<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class Zipper
{
    public static function createZipOf($jsonFileName){
    
        $zip = new ZipArchive();
        $zipFileName = storage_path('app/public/temp/' . now()->timestamp . '-task.zip');

        if($zip->open($zipFileName, ZipArchive::CREATE)===true){
        $filePath = storage_path('app/public/temp/' . $jsonFileName);
        $zip->addFile($filePath, $jsonFileName);
        }
        $zip->close();

        return $zipFileName;
    }
}