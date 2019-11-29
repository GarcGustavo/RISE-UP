<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\case_study;
use App\Models\item;

class SearchController extends Controller
{
    public function show(Request $request){
        $q = $request->input('q');
        $case_study = case_study::where('c_title', 'LIKE', '%'.$q.'%')->orWhere('c_description', 'LIKE', '%'.$q.'%')->get();
        $by_item_content = item::where('i_type','=', 1)->where('i_content', 'LIKE', '%'.$q.'%');

        $all_cases = $case_study->concat($by_item_content)->sortByDesc('cid');

        if (count($all_cases) > 0) {
            return $all_cases;
        } else {
            return ('No Details found. Try to search again !');
        }
    }

}
