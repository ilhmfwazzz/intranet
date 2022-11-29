<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenericController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
        /*$this->middleware('access_list')->only(['index', 'show']);
        $this->middleware('access_create')->only(['create', 'store']);
        $this->middleware('access_edit')->only(['edit', 'update']);
        $this->middleware('access_delete')->only(['destroy']);*/
    }
}
