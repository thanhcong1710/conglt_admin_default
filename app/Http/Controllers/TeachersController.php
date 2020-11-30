<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    public function getDataByKeyword(Request $request,$keyword)
    {
        $data = u::query("SELECT u.* , u.name AS label FROM users AS u LEFT JOIN model_has_roles AS r ON r.model_id=u.id 
            WHERE u.status=1 AND u.branch_id = ".Auth::user()->branch_id." AND r.role_id =" . config('auth.role_teacher')." AND ( u.name LIKE '%$keyword%' OR u.code LIKE '%$keyword%') ");
        return response()->json($data);
    }
}
