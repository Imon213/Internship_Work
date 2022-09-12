<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticController extends Controller
{
	public function about() {
		return view('frontend.pages.static.about');
	}
	public function help() {
		return view('frontend.pages.static.help');
	}
	public function contact() {
		return view('frontend.pages.static.contact');
	}
	public function terms() {
		return view('frontend.pages.static.terms');
	}
	public function agreement() {
		return view('frontend.pages.static.agreement');
	}
	public function privacy() {
		return view('frontend.pages.static.privacy');
	}

}