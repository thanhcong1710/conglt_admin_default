<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;

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
        $data = u::makingPagination($list, 100, $page, $limit);
        return response()->json($data);
    }
}
