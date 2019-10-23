<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItem_TypeAPIRequest;
use App\Http\Requests\API\UpdateItem_TypeAPIRequest;
use App\Models\Item_Type;
use App\Repositories\Item_TypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Item_TypeController
 * @package App\Http\Controllers\API
 */

class Item_TypeAPIController extends AppBaseController
{
    /** @var  Item_TypeRepository */
    private $itemTypeRepository;

    public function __construct(Item_TypeRepository $itemTypeRepo)
    {
        $this->itemTypeRepository = $itemTypeRepo;
    }

    /**
     * Display a listing of the Item_Type.
     * GET|HEAD /itemTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $itemTypes = $this->itemTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($itemTypes->toArray(), 'Item  Types retrieved successfully');
    }

    /**
     * Store a newly created Item_Type in storage.
     * POST /itemTypes
     *
     * @param CreateItem_TypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItem_TypeAPIRequest $request)
    {
        $input = $request->all();

        $itemType = $this->itemTypeRepository->create($input);

        return $this->sendResponse($itemType->toArray(), 'Item  Type saved successfully');
    }

    /**
     * Display the specified Item_Type.
     * GET|HEAD /itemTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Item_Type $itemType */
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            return $this->sendError('Item  Type not found');
        }

        return $this->sendResponse($itemType->toArray(), 'Item  Type retrieved successfully');
    }

    /**
     * Update the specified Item_Type in storage.
     * PUT/PATCH /itemTypes/{id}
     *
     * @param int $id
     * @param UpdateItem_TypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItem_TypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Item_Type $itemType */
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            return $this->sendError('Item  Type not found');
        }

        $itemType = $this->itemTypeRepository->update($input, $id);

        return $this->sendResponse($itemType->toArray(), 'Item_Type updated successfully');
    }

    /**
     * Remove the specified Item_Type from storage.
     * DELETE /itemTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Item_Type $itemType */
        $itemType = $this->itemTypeRepository->find($id);

        if (empty($itemType)) {
            return $this->sendError('Item  Type not found');
        }

        $itemType->delete();

        return $this->sendResponse($id, 'Item  Type deleted successfully');
    }
}
