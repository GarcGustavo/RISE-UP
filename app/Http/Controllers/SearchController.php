<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\case_study;
use App\Models\item;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $q = $request->input('q');
        $case_study_without_content = case_study::where('c_title', 'LIKE', '%'.$q.'%')->orWhere('c_description', 'LIKE', '%'.$q.'%')->get();
        $case_study_with_content = case_study::join('Item', 'Item.i_case', '=', 'Case.cid')
            ->where('i_type', '=', 1)->where('i_content', 'LIKE', '%'.$q.'%')
            ->select('Case.*')->get()->sortByDesc('cid');

        $case_study = $case_study_without_content->concat($case_study_with_content)->sortByDesc('cid');

        if (count($case_study) > 0) {
            return $case_study;
        } else {
            return ('No Details found. Try to search again !');
        }
    }
}
