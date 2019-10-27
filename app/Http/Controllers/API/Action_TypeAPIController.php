<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAction_TypeAPIRequest;
use App\Http\Requests\API\UpdateAction_TypeAPIRequest;
use App\Models\Action_Type;
use App\Repositories\Action_TypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Action_TypeController
 * @package App\Http\Controllers\API
 */

class Action_TypeAPIController extends AppBaseController
{
    /** @var  Action_TypeRepository */
    private $actionTypeRepository;

    public function __construct(Action_TypeRepository $actionTypeRepo)
    {
        $this->actionTypeRepository = $actionTypeRepo;
    }

    /**
     * Display a listing of the Action_Type.
     * GET|HEAD /actionTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $actionTypes = $this->actionTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($actionTypes->toArray(), 'Action  Types retrieved successfully');
    }

    /**
     * Store a newly created Action_Type in storage.
     * POST /actionTypes
     *
     * @param CreateAction_TypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAction_TypeAPIRequest $request)
    {
        $input = $request->all();

        $actionType = $this->actionTypeRepository->create($input);

        return $this->sendResponse($actionType->toArray(), 'Action  Type saved successfully');
    }

    /**
     * Display the specified Action_Type.
     * GET|HEAD /actionTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Action_Type $actionType */
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            return $this->sendError('Action  Type not found');
        }

        return $this->sendResponse($actionType->toArray(), 'Action  Type retrieved successfully');
    }

    /**
     * Update the specified Action_Type in storage.
     * PUT/PATCH /actionTypes/{id}
     *
     * @param int $id
     * @param UpdateAction_TypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAction_TypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Action_Type $actionType */
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            return $this->sendError('Action  Type not found');
        }

        $actionType = $this->actionTypeRepository->update($input, $id);

        return $this->sendResponse($actionType->toArray(), 'Action_Type updated successfully');
    }

    /**
     * Remove the specified Action_Type from storage.
     * DELETE /actionTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Action_Type $actionType */
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            return $this->sendError('Action  Type not found');
        }

        $actionType->delete();

        return $this->sendResponse($id, 'Action  Type deleted successfully');
    }
}
