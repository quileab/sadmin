<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        
            // user Student Creation
            $user=User::create([
                'name' => $row['name'],
                'pid' => $row['pid'],
                'lastname' => $row['lastname'],
                'firstname' => $row['firstname'],
                'phone' => $row['phone'],
                'enabled' => $row['enabled'],
                'email' => $row['email'],
                'password' => Hash::make($row['pid']),
            ]);

            // TODO: Ver como agrego Carreras a los estudiantes

            // $user->career::create([
            //     'career'=>$rows['career'],
            // ]);
        }
        
        // return redirect()->back()->with(['message'=>'Usuarios importados correctamente']);
        return redirect(route('students'));
    }
}
