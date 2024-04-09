<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->file->extension();  
        $request->file->move(public_path('storage/upluads'), $imageName);
    
        return response()->json([
            'url' => asset('storage/uploads/'.$imageName),
        ]);
    }
}
