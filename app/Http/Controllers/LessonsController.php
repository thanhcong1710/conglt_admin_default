<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonsController extends Controller
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
        $cond = " c.branch_id = " . (int)Auth::user()->branch_id;
        if ($status !== '') {
            $cond .= " AND c.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND c.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_lessons AS c WHERE $cond");
        $list = u::query("SELECT c.* FROM lms_lessons AS c WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'branch_id' => Auth::user()->branch_id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'description' => $request->description,
        ), 'lms_lessons');
        return response()->json($data);
    }
    public function detail($course_id)
    {
        $data = u::getObject(array('id' => $course_id), 'lms_lessons');
        return response()->json($data);
    }
    public function update(Request $request, $course_id)
    {
        $data = u::updateSimpleRow(array(
            'title' => $request->title,
            'course_id' => $request->course_id,
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'description' => $request->description,
        ), array('id' => $course_id), 'lms_lessons');
        return response()->json($data);
    }
    public function delete($course_id)
    {
        $data = u::query("DELETE FROM lms_lessons WHERE id=$course_id");
        return response()->json($data);
    }
}
