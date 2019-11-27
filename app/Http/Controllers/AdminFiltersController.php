<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFiltersController extends Controller
{
    //public function index
    //allows to view a list of search filters for case studies
    public function index(){

        $categories = DB::table('cs_parameter')
            ->select('cs_parameter.*')
            ->get();

        $options = DB::table('option')
            ->select('option.*')
            ->get();

        return view('admin.filters.index', ['categories' => $categories, 'options' => $options]);
    }
}
