<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftsController extends Controller
{
    public function getAll(Request $request)
    {
        $data = u::getMultiObject(array('status' => 1, 'branch_id' => Auth::user()->branch_id), 'lms_shifts');
        return response()->json($data);
    }
}
