<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClearanceController extends Controller
{
    //

    public function index () 
    {
        
    }

    public function show (int $id, Request $request) 
    {
        try {
            
            return response () -> json ([
                "id" => $id,
                "params" => $request->all(),
            ], 200);
        } catch (\Exception $e) {
            return response () -> json ([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
