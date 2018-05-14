<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Lib\Common;
use App\Page;
use App\Models\SysMenu;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Models\WhItems;
use App\Models\WhShelf;
use App\Models\WhUnit;
use App\Lib\SysKey;


class UserController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	$user = session('wapUser');
    	$menu = null;
        return view('wap.user.index',['menu'=>$menu]);
    }
   
}
