<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $status = isset($request->status) ? $request->status : '';
        $class_id = isset($request->class_id) ? $request->class_id : '';
        $cond = " c.branch_id = " . (int)Auth::user()->branch_id;

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page-1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit": "";
        
        if ($status == 2) {
            $cond .= " AND s.date >= CURRENT_DATE";
        }elseif ($status==1) {
            $cond .= " AND s.date < CURRENT_DATE";
        }
        if ($class_id !== '') {
            $cond .= " AND s.class_id LIKE '%$class_id%' ";
        }
        $total = u::first("SELECT count(s.id) AS total FROM lms_schedules AS s LEFT JOIN lms_classes AS c ON c.id=s.class_id WHERE $cond");
        $list = u::query("SELECT c.title AS class_name, s.* ,
                IF(s.date >= CURRENT_DATE,'Chưa học','Đã học') AS status_title
            FROM lms_schedules AS s LEFT JOIN lms_classes AS c ON c.id=s.class_id WHERE $cond $limitation");
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
            'teacher_id' => $request->teacher_id,
            'start_date' => $request->start_date,
            'session' => $request->session,
            'title' => $request->title,
            'status' => $request->status,
            'shifts' => $shifts,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_schedules');
        return response()->json($data);
    }
    public function detail($class_id)
    {
        $data = u::getObject(array('id' => $class_id), 'lms_schedules');
        $data->shift_selected = u::query("SELECT * FROM lms_shifts WHERE id IN(" . ($data->shifts ? $data->shifts : 0) . ")");
        $teacher_info = $data->teacher_id ? u::first("SELECT name FROM users WHERE id =" . $data->teacher_id ): NULL;
        $data->teacher_name = $teacher_info ? $teacher_info->name:'';
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
            'teacher_id' => $request->teacher_id,
            'title' => $request->title,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'session' => $request->session,
            'shifts' => $shifts,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $class_id), 'lms_schedules');
        return response()->json($data);
    }
    public function delete($class_id)
    {
        $data = u::query("DELETE FROM lms_schedules WHERE id=$class_id");
        return response()->json($data);
    }
}
