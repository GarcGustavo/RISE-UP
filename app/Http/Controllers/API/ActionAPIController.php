<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateActionAPIRequest;
use App\Http\Requests\API\UpdateActionAPIRequest;
use App\Models\Action;
use App\Repositories\ActionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ActionController
 * @package App\Http\Controllers\API
 */

class ActionAPIController extends AppBaseController
{
    /** @var  ActionRepository */
    private $actionRepository;

    public function __construct(ActionRepository $actionRepo)
    {
        $this->actionRepository = $actionRepo;
    }

    /**
     * Display a listing of the Action.
     * GET|HEAD /actions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $actions = $this->actionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($actions->toArray(), 'Actions retrieved successfully');
    }

    /**
     * Store a newly created Action in storage.
     * POST /actions
     *
     * @param CreateActionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateActionAPIRequest $request)
    {
        $input = $request->all();

        $action = $this->actionRepository->create($input);

        return $this->sendResponse($action->toArray(), 'Action saved successfully');
    }

    /**
     * Display the specified Action.
     * GET|HEAD /actions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Action $action */
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            return $this->sendError('Action not found');
        }

        return $this->sendResponse($action->toArray(), 'Action retrieved successfully');
    }

    /**
     * Update the specified Action in storage.
     * PUT/PATCH /actions/{id}
     *
     * @param int $id
     * @param UpdateActionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Action $action */
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            return $this->sendError('Action not found');
        }

        $action = $this->actionRepository->update($input, $id);

        return $this->sendResponse($action->toArray(), 'Action updated successfully');
    }

    /**
     * Remove the specified Action from storage.
     * DELETE /actions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Action $action */
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            return $this->sendError('Action not found');
        }

        $action->delete();

        return $this->sendResponse($id, 'Action deleted successfully');
    }
}
