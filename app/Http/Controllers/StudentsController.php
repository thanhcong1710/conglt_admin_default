<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $status = isset($request->status) ? $request->status : '';
        $keyword = isset($request->keyword) ? $request->keyword : '';
        
        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page-1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit": "";

        $cond = " s.branch_id = ".(int)Auth::user()->branch_id;
        if ($status !== '') {
            $cond .= " AND s.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND (s.name LIKE '%$keyword%' OR s.phone LIKE '%$keyword%') ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_students AS s WHERE $cond $limitation");
        $list = u::query("SELECT s.* FROM lms_students AS s WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'branch_id'=>Auth::user()->branch_id,
            'name'=>$request->name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_students');
        return response()->json($data);
    }
    public function detail($student_id)
    {
        $data = u::getObject(array('id' => $student_id), 'lms_students');
        return response()->json($data);
    }
    public function update(Request $request, $student_id)
    {
        $data = u::updateSimpleRow(array(
            'name'=>$request->name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $student_id), 'lms_students');
        return response()->json($data);
    }
    public function delete($student_id)
    {
        $data = u::query("DELETE FROM lms_students WHERE id=$student_id");
        return response()->json($data);
    }
}
