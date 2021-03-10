<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchesController extends Controller
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

        $cond = " 1 ";
        if ($status !== '') {
            $cond .= " AND p.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND p.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_branches AS p WHERE $cond");
        $list = u::query("SELECT p.* FROM lms_branches AS p WHERE $cond $limitation");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_branches');
        return response()->json($data);
    }
    public function detail($branch_id)
    {
        $data = u::getObject(array('id' => $branch_id), 'lms_branches');
        return response()->json($data);
    }
    public function update(Request $request, $branch_id)
    {
        $data = u::updateSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $branch_id), 'lms_branches');
        return response()->json($data);
    }
    public function delete($branch_id)
    {
        $data = u::query("DELETE FROM lms_branches WHERE id=$branch_id");
        return response()->json($data);
    }
}
