<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function importBulk(Request $request){
        $request->validate(
            [
                'file'=>'required',
            ]
            );
    
        $file=$request->file('file');
        $csvData=file_get_contents($file);
        $rows=array_map('str_getcsv',explode("\n",$csvData));
        $header=array_shift($rows);
        
        foreach ($rows as $row){
            $row=array_combine($header,$row); // convierte en array asociativo con los datos de $header
        }
        
    }
}
