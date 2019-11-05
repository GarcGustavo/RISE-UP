<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Study;
use App\Models\Item;
use App\Http\Resources\Item as ItemResource;

class ItemController extends Controller
{

    public function getCaseItems($id)
    {
        $cid = $id;
        $item = ItemResource::
        $caseItems = Item:: orderBy('Item.order')
        ->where('Item.i_case', $cid)
        ->select('Item.*')
        ->get();

        return ItemResource::collection($caseItems);
    }

    public function addCaseItem($id)
    {
        $caseItem = $request->isMethod('put') ? Item::findOrFail($request->gid): new group;

        $caseItem->gid = $request -> input('gid');
        $caseItem->gname = $request -> input('gname');
        $caseItem->g_status = $request -> input('g_status');
        $caseItem->g_creation_date = $request -> input('g_creation_date');
        $caseItem->g_owner = $request -> input('g_owner');

        if ($caseItem->save()) {
            return new ItemResource($caseItem);
        }
    }

    public function removeCaseItem($id)
    {
        $to_delete = $request->all();
        $cids_to_delete = array_map(function($item){ return $item['gid']; }, $to_delete);
        $iids_to_delete = array_map(function($item){ return $item['uid']; }, $to_delete);
        User_Groups::whereIn('gid', $gids_to_delete)->whereIn('uid', $uids_to_delete)->delete();
        return response()->json(['message'=>'User(s) has been removed from group']);
    }

    public function updateItemOrder(Request $request, $id)
    {
        $this->validate($request, [
            'items.*.order' => 'required|numeric',
        ]);

        $caseItems = Item::all();

        foreach ($caseItems as $item) {
            $cid = $item->i_case;
            foreach ($request->caseItems as $itemsNew) {
                if ($caseItemsNew['i_case'] == $cid) {
                    $caseItems->update(['order' => $caseItemsNew['order']]);
                }
            }
        }

        return response('Updated Successfully.', 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
