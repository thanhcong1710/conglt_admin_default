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
        $cond = " l.branch_id = " . (int)Auth::user()->branch_id;

        $pagination = (object)$request->pagination;
        $page = isset($pagination->cpage) ? (int) $pagination->cpage : 1;
        $limit = isset($pagination->limit) ? (int) $pagination->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page-1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit": "";

        if ($status !== '') {
            $cond .= " AND l.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND l.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_classes AS l WHERE $cond");
        $list = u::query("SELECT l.* , (SELECT title FROM lms_products WHERE id=l.product_id) AS product_name FROM lms_classes AS l WHERE $cond $limitation");
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
        ), 'lms_classes');
        return response()->json($data);
    }
    public function detail($class_id)
    {
        $data = u::getObject(array('id' => $class_id), 'lms_classes');
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
        ), array('id' => $class_id), 'lms_classes');
        self::genSchedules($class_id);
        return response()->json($data);
    }
    public function delete($class_id)
    {
        $data = u::query("DELETE FROM lms_classes WHERE id=$class_id");
        return response()->json($data);
    }
    public static function genSchedules($class_id){
        $class_info = u::first("SELECT * FROM lms_classes WHERE id = $class_id");
        $shifts = u::query("SELECT * FROM lms_shifts WHERE id IN ($class_info->shifts) ");
        $holiday = [];
        $arr_class_day = [];
        $arr_shift = [];
        foreach($shifts AS $shift){
            array_push($arr_class_day,$shift->day);
            $arr_shift[$shift->day] =$shift;
        }
        $data = u::calculatorSessionsByNumberOfSessions($class_info->start_date,$class_info->session,$holiday,$arr_class_day);
        foreach($data->dates AS $date){
            $check_date = u::first("SELECT count(id) AS total FROM  lms_schedules WHERE class_id=$class_info->id AND `date`='$date'");
            if($check_date->total==0){
                $wday = date('w', strtotime($date));
                u::insertSimpleRow(array(
                    'date' => $date,
                    'shift_id' => $arr_shift[$wday]->id,
                    'class_id' => $class_info->id,
                    'start_time' => $arr_shift[$wday]->start_time,
                    'end_time' => $arr_shift[$wday]->end_time,
                    'duration' => strtotime($arr_shift[$wday]->end_time) -strtotime($arr_shift[$wday]->start_time),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'creator_id' => Auth::user()->id,
                ), 'lms_schedules');
            }
        }
    }
    public function getDataByKeyword(Request $request,$keyword)
    {
        $data = u::query("SELECT * , title AS label FROM lms_classes WHERE status=1 AND branch_id = ".Auth::user()->branch_id." AND ( title LIKE '%$keyword%' OR id LIKE '%$keyword%') ");
        return response()->json($data);
    }
}
