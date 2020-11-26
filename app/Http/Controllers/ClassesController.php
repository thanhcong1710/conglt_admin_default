<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
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
        $cond = " l.branch_id = " . (int)Auth::user()->branch_id;
        if ($status !== '') {
            $cond .= " AND l.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND l.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_classes AS l WHERE $cond");
        $list = u::query("SELECT l.* , (SELECT title FROM lms_products WHERE id=l.product_id) AS product_name FROM lms_classes AS l WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $shifts = '';
        foreach ($request->shift_selected as $row) {
            $row = (object)$row;
            $shifts .= $shifts ? "," . $row->id : $row->id;
        }
        $data = u::insertSimpleRow(array(
            'branch_id' => Auth::user()->branch_id,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'status' => $request->status,
            'shifts' => $shifts,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_classes');
        return response()->json($data);
    }
    public function detail($class_id)
    {
        $data = u::getObject(array('id' => $class_id), 'lms_classes');
        $data->shift_selected = u::query("SELECT * FROM lms_shifts WHERE id IN(" . ($data->shifts ? $data->shifts : 0) . ")");
        return response()->json($data);
    }
    public function update(Request $request, $class_id)
    {
        $shifts = '';
        foreach ($request->shift_selected as $row) {
            $row = (object)$row;
            $shifts .= $shifts ? "," . $row->id : $row->id;
        }
        $data = u::updateSimpleRow(array(
            'product_id' => $request->product_id,
            'title' => $request->title,
            'status' => $request->status,
            'shifts' => $shifts,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $class_id), 'lms_classes');
        return response()->json($data);
    }
    public function delete($class_id)
    {
        $data = u::query("DELETE FROM lms_classes WHERE id=$class_id");
        return response()->json($data);
    }
}
