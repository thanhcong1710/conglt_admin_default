<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TuitionFeesController extends Controller
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
        $page = isset($request->page) ? (int) $request->page : 1;
        $limit = isset($request->limit) ? (int) $request->limit : 20;
        $cond = " p.branch_id = ".(int)Auth::user()->branch_id;
        if ($status !== '') {
            $cond .= " AND p.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND p.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_tuition_fees AS p WHERE $cond");
        $list = u::query("SELECT p.* FROM lms_tuition_fees AS p WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'branch_id'=> Auth::user()->branch_id,
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_tuition_fees');
        return response()->json($data);
    }
    public function detail($tuition_fee_id)
    {
        $data = u::getObject(array('id' => $tuition_fee_id), 'lms_tuition_fees');
        return response()->json($data);
    }
    public function update(Request $request, $tuition_fee_id)
    {
        $data = u::updateSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $tuition_fee_id), 'lms_tuition_fees');
        return response()->json($data);
    }
    public function delete($branch_id)
    {
        $data = u::query("DELETE FROM lms_tuition_fees WHERE id=$branch_id");
        return response()->json($data);
    }
    public function getAll(Request $request)
    {
        $data = u::getMultiObject(array('status'=>1,'branch_id'=>Auth::user()->branch_id),'lms_tuition_fees');
        return response()->json($data);
    }
}
