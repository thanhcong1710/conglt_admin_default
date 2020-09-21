<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizsController extends Controller
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
        $cond = " 1 ";
        if ($status !== '') {
            $cond .= " AND q.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND q.ma_cauhoi LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_quiz AS q WHERE $cond");
        $list = u::query("SELECT q.* FROM lms_quiz AS q WHERE $cond");
        foreach ($list as $k => $row) {
            $list[$k]->noidung_quiz = json_decode($row->noidung_quiz);
        }
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add1(Request $request)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['dapan_quiz'] =  $request->dapan_quiz;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['created_at'] = date('Y-m-d H:i:s');
        $arr_input['creator_id'] = Auth::user()->id;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $noidung_quiz['template'] = $request->noidung_template;
        $noidung_quiz['is_multichoice'] = $request->noidung_is_multichoice;
        $noidung_quiz['option_html'] = $request->noidung_option;
        $noidung_option_html = $request->noidung_option;
        $noidung_option_html = str_replace('</p>', '/*/', $noidung_option_html);
        $noidung_option_html = str_replace('<p>', '', $noidung_option_html);
        $arr_option = explode('/*/', $noidung_option_html);
        $option = array();
        foreach ($arr_option as $op) {
            $op = trim($op);
            if ($op != "") {
                $key = intval(substr($op, 0, 1));
                $value = trim(substr($op, 2));
                $option[$key] = $value;
            }
        }
        $noidung_quiz['option'] = $option;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $data = u::insertSimpleRow($arr_input, 'lms_quiz');

        return response()->json($data);
    }
    public function add2(Request $request)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['created_at'] = date('Y-m-d H:i:s');
        $arr_input['creator_id'] = Auth::user()->id;
        $arr_input['meta_data'] = $request->dapan_quiz;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $noidung_quiz['template'] = $request->noidung_template;
        $noidung_quiz['type_convert'] = $request->noidung_type_convert;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $dapan_quiz_html = $request->dapan_quiz;
        $dapan_quiz_html = str_replace('</p>', '/*/', $dapan_quiz_html);
        $dapan_quiz_html = str_replace('<p>', '', $dapan_quiz_html);
        $arr_dapan = explode('/*/', $dapan_quiz_html);
        $dapan_quiz = array();
        foreach ($arr_dapan as $op) {
            $op = trim($op);
            if ($op != "") {
                $key = intval(substr($op, 0, 1));
                $value = trim(substr($op, 2));
                $dapan_quiz[$key] = $value;
            }
        }
        $arr_input['dapan_quiz'] = json_encode($dapan_quiz, true);
        $data = u::insertSimpleRow($arr_input, 'lms_quiz');

        return response()->json($data);
    }
    public function add3(Request $request)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['created_at'] = date('Y-m-d H:i:s');
        $arr_input['creator_id'] = Auth::user()->id;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $data = u::insertSimpleRow($arr_input, 'lms_quiz');

        return response()->json($data);
    }
    public function detail($quiz_id)
    {
        $data = u::getObject(array('id' => $quiz_id), 'lms_quiz');
        $data->noidung_quiz = json_decode($data->noidung_quiz);
        return response()->json($data);
    }
    public function update1(Request $request, $quiz_id)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['dapan_quiz'] =  $request->dapan_quiz;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['updated_at'] = date('Y-m-d H:i:s');
        $arr_input['updator_id'] = Auth::user()->id;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $noidung_quiz['template'] = $request->noidung_template;
        $noidung_quiz['is_multichoice'] = $request->noidung_is_multichoice;
        $noidung_quiz['option_html'] = $request->noidung_option;
        $noidung_option_html = $request->noidung_option;
        $noidung_option_html = str_replace('</p>', '/*/', $noidung_option_html);
        $noidung_option_html = str_replace('<p>', '', $noidung_option_html);
        $arr_option = explode('/*/', $noidung_option_html);
        $option = array();
        foreach ($arr_option as $op) {
            $op = trim($op);
            if ($op != "") {
                $key = "option_".intval(substr($op, 0, 1));
                $value = trim(substr($op, 2));
                $option[$key] = $value;
            }
        }
        $noidung_quiz['option'] = $option;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $data = u::updateSimpleRow($arr_input, array('id' => $quiz_id), 'lms_quiz');
        return response()->json($data);
    }
    public function update2(Request $request, $quiz_id)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['created_at'] = date('Y-m-d H:i:s');
        $arr_input['creator_id'] = Auth::user()->id;
        $arr_input['meta_data'] = $request->dapan_quiz;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $noidung_quiz['template'] = $request->noidung_template;
        $noidung_quiz['type_convert'] = $request->noidung_type_convert;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $dapan_quiz_html = $request->dapan_quiz;
        $dapan_quiz_html = str_replace('</p>', '/*/', $dapan_quiz_html);
        $dapan_quiz_html = str_replace('<p>', '', $dapan_quiz_html);
        $arr_dapan = explode('/*/', $dapan_quiz_html);
        $dapan_quiz = array();
        foreach ($arr_dapan as $op) {
            $op = trim($op);
            if ($op != "") {
                $key = intval(substr($op, 0, 1));
                $value = trim(substr($op, 2));
                $dapan_quiz[$key] = $value;
            }
        }
        $arr_input['dapan_quiz'] = json_encode($dapan_quiz, true);
        $data = u::updateSimpleRow($arr_input, array('id' => $quiz_id), 'lms_quiz');

        return response()->json($data);
    }
    public function update3(Request $request, $quiz_id)
    {
        $arr_input['type'] = $request->type;
        $arr_input['ma_cauhoi'] = $request->ma_cauhoi;
        $arr_input['dokho_quiz'] = $request->dokho_quiz;
        $arr_input['status'] = $request->status;
        $arr_input['giaithich_quiz'] =  $request->giaithich_quiz;
        $arr_input['created_at'] = date('Y-m-d H:i:s');
        $arr_input['creator_id'] = Auth::user()->id;

        $noidung_quiz = array();
        $noidung_quiz['intro'] = $request->noidung_intro;
        $arr_input['noidung_quiz'] = json_encode($noidung_quiz, true);
        $data = u::updateSimpleRow($arr_input, array('id' => $quiz_id), 'lms_quiz');

        return response()->json($data);
    }
    public function getNoiDungQuiz($quiz_id)
    {
        $data = u::first("SELECT id AS quiz_id,noidung_quiz FROM lms_quiz WHERE id=$quiz_id");
        $data->noidung_quiz = json_decode($data->noidung_quiz,true);
        u::shuffle_assoc($data->noidung_quiz['option']);
        return response()->json($data);
    }
}
