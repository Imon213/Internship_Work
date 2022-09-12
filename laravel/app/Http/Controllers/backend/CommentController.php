<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommentModel;
use Carbon\Carbon;
use App\Models\User;

class CommentController extends Controller
{
	public function showList() {
      $dataList = CommentModel::leftJoin('users', 'comments.comments_users_id', 'users.users_track_id')
            ->leftJoin('products', 'comments.comments_products_id', 'products.products_track_id')
            ->select('comments.*', 'users.users_name', 'products.products_name')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('backend.pages.comment.list', compact('dataList'));
    }


    public function activate(Request $request) {
    	$id = $request->input('comments_track_id');
        $dataList = CommentModel::where('comments_track_id', $id)->first();
        $dataList->comments_status = 'Active';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'Comment Activated');
        }
    }
    public function inActivate(Request $request) {
    	$id = $request->input('comments_track_id');
        $dataList = CommentModel::where('comments_track_id', $id)->first();
        $dataList->comments_status = 'Inactive';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'Comment Inactivated');
        }
    }
}