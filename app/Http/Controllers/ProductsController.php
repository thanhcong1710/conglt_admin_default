<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
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
            $cond .= " AND p.status=$status";
        }
        if ($keyword !== '') {
            $cond .= " AND p.title LIKE '%$keyword%' ";
        }
        $total = u::first("SELECT count(id) AS total FROM lms_products AS p WHERE $cond");
        $list = u::query("SELECT p.* FROM lms_products AS p WHERE $cond");
        $data = u::makingPagination($list, $total->total, $page, $limit);
        return response()->json($data);
    }
    public function add(Request $request)
    {
        $data = u::insertSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
            'created_at' => date('Y-m-d H:i:s'),
            'creator_id' => Auth::user()->id,
            'note' => $request->note,
        ), 'lms_products');
        return response()->json($data);
    }
    public function detail($product_id)
    {
        $data = u::getObject(array('id' => $product_id), 'lms_products');
        return response()->json($data);
    }
    public function update(Request $request, $product_id)
    {
        $data = u::updateSimpleRow(array(
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
            'updated_at' => date('Y-m-d H:i:s'),
            'updator_id' => Auth::user()->id,
            'note' => $request->note,
        ), array('id' => $product_id), 'lms_products');
        return response()->json($data);
    }
    public function delete($branch_id)
    {
        $data = u::query("DELETE FROM lms_products WHERE id=$branch_id");
        return response()->json($data);
    }
}
