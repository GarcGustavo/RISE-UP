<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Case_Study;
use App\Models\Item;
use App\Http\Resources\Item as ItemResource;

class ItemController extends Controller
{

     /**
     * Get item of a specificied case study
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @return \App\Http\Resources\item
     */
    public function getCaseItems($id)
    {
        $cid = $id;
        $caseItems = Item:: orderBy('Item.order')
        ->where('Item.i_case', $cid)
        ->select('Item.*')
        ->get();

        return ItemResource::collection($caseItems);
    }

 /**
     * Store case item in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @return \App\Http\Resources\item
     */
    public function addCaseItem(Request $request)
    {
        $caseItem = $request->isMethod('put') ? Item::findOrFail($request->iid): new item;

        $caseItem->iid = $request -> input('iid');
        $caseItem->i_content = $request -> input('i_content');
        $caseItem->i_case = $request -> input('i_case');
        $caseItem->i_type = $request -> input('i_type');
        $caseItem->order = $request -> input('order');
        $caseItem->i_name = $request -> input('i_name');

        if ($caseItem->save()) {
            return new ItemResource($caseItem);
        }
    }
     /**
     * Rearranges an item's positioning 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $items = Item::all();

        return ItemResource::collection($items);
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

        if(($request->i_type == 2) && ($request->hasFile('image'))){
            $content = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $content);
        }
        else{
            $content= $request->i_content;
        }
        $type = $request->i_type;
        $order = $request->order;
        $name = $request->i_name;
        Item::where(['iid' => $request->input('iid')])->update(['i_content' => $content,'i_type' => $type,'order' => $order,'i_name' => $name]);
        return response()->json(['message'=>'Updated item successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function destroy(Request $request)
    {
        //$to_delete = $request->all();
        //$iid_to_delete = array_map(function($item){ return $item['iid']; }, $to_delete);
        //$iid_to_delete = $id;
        //$items_to_delete = Item::
        //->where('Item.iid', $iid_to_delete)
        //->delete();
        //Item::whereIn('iid', $iid_to_delete)->delete();
        //return response()->json(['message'=>'Item has been removed from case']);
    }
    public function removeItem(Request $request)
    {
        $iid_to_delete = $request->input('iid');
        Item::where('iid', $iid_to_delete)->delete();
        return response()->json(['message'=>'Item has been removed from case']);
    }
}
