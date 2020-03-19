<?php

namespace HCES\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function load($disk, $filename){
        return response()->download(Storage::disk(decrypt($disk))->getAdapter()->getPathPrefix() . '' . decrypt($filename), null, [], null);
    }
}
