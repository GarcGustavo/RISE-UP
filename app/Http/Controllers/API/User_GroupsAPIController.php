<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUser_GroupsAPIRequest;
use App\Http\Requests\API\UpdateUser_GroupsAPIRequest;
use App\Models\User_Groups;
use App\Repositories\User_GroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class User_GroupsController
 * @package App\Http\Controllers\API
 */

class User_GroupsAPIController extends AppBaseController
{
    /** @var  User_GroupsRepository */
    private $userGroupsRepository;

    public function __construct(User_GroupsRepository $userGroupsRepo)
    {
        $this->userGroupsRepository = $userGroupsRepo;
    }

    /**
     * Display a listing of the User_Groups.
     * GET|HEAD /userGroups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userGroups = $this->userGroupsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userGroups->toArray(), 'User  Groups retrieved successfully');
    }

    /**
     * Store a newly created User_Groups in storage.
     * POST /userGroups
     *
     * @param CreateUser_GroupsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUser_GroupsAPIRequest $request)
    {
        $input = $request->all();

        $userGroups = $this->userGroupsRepository->create($input);

        return $this->sendResponse($userGroups->toArray(), 'User  Groups saved successfully');
    }

    /**
     * Display the specified User_Groups.
     * GET|HEAD /userGroups/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User_Groups $userGroups */
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            return $this->sendError('User  Groups not found');
        }

        return $this->sendResponse($userGroups->toArray(), 'User  Groups retrieved successfully');
    }

    /**
     * Update the specified User_Groups in storage.
     * PUT/PATCH /userGroups/{id}
     *
     * @param int $id
     * @param UpdateUser_GroupsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUser_GroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var User_Groups $userGroups */
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            return $this->sendError('User  Groups not found');
        }

        $userGroups = $this->userGroupsRepository->update($input, $id);

        return $this->sendResponse($userGroups->toArray(), 'User_Groups updated successfully');
    }

    /**
     * Remove the specified User_Groups from storage.
     * DELETE /userGroups/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User_Groups $userGroups */
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            return $this->sendError('User  Groups not found');
        }

        $userGroups->delete();

        return $this->sendResponse($id, 'User  Groups deleted successfully');
    }
}
