<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PrivateFilesController extends Controller
{
    public function files($file)
    {
        //check if user has any role of admin or secretary
        if (auth()->user()->hasAnyRole(['admin', 'secretary'])) {
            //check if file exists
            $path="app/private/inscriptions/{$file}";
            $storage="private/inscriptions/{$file}";
            if (Storage::exists($storage)) {
                // return Storage::download($path);
                //return response()->download($path,'file.pdf', ['Content-Type' => 'application/pdf'], 'inline');
                return Response::make(file_get_contents(storage_path($path)), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$file.'"'
                ]);
            }
            abort(404);
        } else {
            //user not authorized
            abort(401);
        }

    }
}
