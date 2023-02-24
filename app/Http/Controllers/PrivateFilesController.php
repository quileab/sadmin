<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PrivateFilesController extends Controller
{
    public function files($file)
    {
        $path = "app/private/inscriptions/{$file}";
        $storage = "private/inscriptions/{$file}";
        //check if user has any role of admin or secretary
        if ((auth()->user()->hasAnyRole(['admin', 'secretary']) || 
            // or files belongsTo current user
            str_contains($file,'insc-'.auth()->user()->id.'-')) &&
            // and file exists
            (Storage::exists($storage))
        ) {
            return Response::make(file_get_contents(storage_path($path)), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$file.'"',
            ]);
        } 
        abort(404);
    }
}
