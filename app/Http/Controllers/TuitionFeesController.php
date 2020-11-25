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
        $cond = " t.branch_id = ".(int)Auth::user()->branch_id;
        if ($status !== '') {
            $cond .= " AND t.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND t.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_tuition_fees AS t WHERE $cond");
        $list = u::query("SELECT t.* FROM lms_tuition_fees AS t WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'branch_id'=> Auth::user()->branch_id,
            'product_id'=>$request->product_id,
            'title' => $request->title,
            'session'=>$request->session,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'receivable'=>$request->receivable,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_tuition_fees');
        return response()->json($data);
    }
    public function detail($tuition_fee_id)
    {
        $data = u::getObject(array('id' => $tuition_fee_id), 'lms_tuition_fees');
        $data->price_show = number_format($data->price);
        $data->discount_show = number_format($data->discount);
        $data->receivable_show = number_format($data->receivable);
        return response()->json($data);
    }
    public function update(Request $request, $tuition_fee_id)
    {
        $data = u::updateSimpleRow(array(
            'product_id'=>$request->product_id,
            'title' => $request->title,
            'session'=>$request->session,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'receivable'=>$request->receivable,
            'status' => $request->status,
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
}
