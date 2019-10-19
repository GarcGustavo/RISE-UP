<?php

namespace App\Http\Controllers;

use App\Item_Type;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item_Type = Item_Type::all();
        return view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item_type = new Item_Type();
        $item_type->itt_name = $request('itt_name');
        

        $item_type->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item_Type  $item_Type
     * @return \Illuminate\Http\Response
     */
    public function show(Item_Type $item_Type)
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item_Type  $item_Type
     * @return \Illuminate\Http\Response
     */
    public function edit(Item_Type $item_Type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item_Type  $item_Type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item_Type $item_Type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item_Type  $item_Type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item_Type $item_Type)
    {
        //
    }
}
