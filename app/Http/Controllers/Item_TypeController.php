<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItem_TypeRequest;
use App\Http\Requests\UpdateItem_TypeRequest;
use App\Repositories\Item_TypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class Item_TypeController extends AppBaseController
{
    /** @var  Item_TypeRepository */
    private $itemTypeRepository;

    public function __construct(Item_TypeRepository $itemTypeRepo)
    {
        $this->itemTypeRepository = $itemTypeRepo;
    }

    /**
     * Display a listing of the Item_Type.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $itemTypes = $this->itemTypeRepository->all();

        return view('item__types.index')
            ->with('itemTypes', $itemTypes);
    }

    /**
     * Show the form for creating a new Item_Type.
     *
     * @return Response
     */
    public function create()
    {
        return view('item__types.create');
    }

    /**
     * Store a newly created Item_Type in storage.
     *
     * @param CreateItem_TypeRequest $request
     *
     * @return Response
     */
    public function store(CreateItem_TypeRequest $request)
    {
        $input = $request->all();

        $itemType = $this->itemTypeRepository->create($input);

        Flash::success('Item  Type saved successfully.');

        return redirect(route('itemTypes.index'));
    }

    /**
     * Display the specified Item_Type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            Flash::error('Item  Type not found');

            return redirect(route('itemTypes.index'));
        }

        return view('item__types.show')->with('itemType', $itemType);
    }

    /**
     * Show the form for editing the specified Item_Type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            Flash::error('Item  Type not found');

            return redirect(route('itemTypes.index'));
        }

        return view('item__types.edit')->with('itemType', $itemType);
    }

    /**
     * Update the specified Item_Type in storage.
     *
     * @param int $id
     * @param UpdateItem_TypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItem_TypeRequest $request)
    {
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            Flash::error('Item  Type not found');

            return redirect(route('itemTypes.index'));
        }

        $itemType = $this->itemTypeRepository->update($request->all(), $id);

        Flash::success('Item  Type updated successfully.');

        return redirect(route('itemTypes.index'));
    }

    /**
     * Remove the specified Item_Type from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            Flash::error('Item  Type not found');

            return redirect(route('itemTypes.index'));
        }

        $this->itemTypeRepository->delete($id);

        Flash::success('Item  Type deleted successfully.');

        return redirect(route('itemTypes.index'));
    }
}
