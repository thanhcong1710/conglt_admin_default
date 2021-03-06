<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
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
        $total = u::first("SELECT count(id) AS total FROM lms_courses AS c WHERE $cond");
        $list = u::query("SELECT c.* FROM lms_courses AS c WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'branch_id' => Auth::user()->branch_id,
            'title' => $request->title,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_courses');
        return response()->json($data);
    }
    public function detail($course_id)
    {
        $data = u::getObject(array('id' => $course_id), 'lms_courses');
        return response()->json($data);
    }
    public function update(Request $request, $course_id)
    {
        $data = u::updateSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $course_id), 'lms_courses');
        return response()->json($data);
    }
    public function delete($course_id)
    {
        $data = u::query("DELETE FROM lms_courses WHERE id=$course_id");
        return response()->json($data);
    }
    public function getAll(Request $request)
    {
        $data = u::getMultiObject(array('status'=>1,'branch_id'=>Auth::user()->branch_id),'lms_courses');
        return response()->json($data);
    }
}
