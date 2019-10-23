<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser_GroupsRequest;
use App\Http\Requests\UpdateUser_GroupsRequest;
use App\Repositories\User_GroupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class User_GroupsController extends AppBaseController
{
    /** @var  User_GroupsRepository */
    private $userGroupsRepository;

    public function __construct(User_GroupsRepository $userGroupsRepo)
    {
        $this->userGroupsRepository = $userGroupsRepo;
    }

    /**
     * Display a listing of the User_Groups.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userGroups = $this->userGroupsRepository->all();

        return view('user__groups.index')
            ->with('userGroups', $userGroups);
    }

    /**
     * Show the form for creating a new User_Groups.
     *
     * @return Response
     */
    public function create()
    {
        return view('user__groups.create');
    }

    /**
     * Store a newly created User_Groups in storage.
     *
     * @param CreateUser_GroupsRequest $request
     *
     * @return Response
     */
    public function store(CreateUser_GroupsRequest $request)
    {
        $input = $request->all();

        $userGroups = $this->userGroupsRepository->create($input);

        Flash::success('User  Groups saved successfully.');

        return redirect(route('userGroups.index'));
    }

    /**
     * Display the specified User_Groups.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            Flash::error('User  Groups not found');

            return redirect(route('userGroups.index'));
        }

        return view('user__groups.show')->with('userGroups', $userGroups);
    }

    /**
     * Show the form for editing the specified User_Groups.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            Flash::error('User  Groups not found');

            return redirect(route('userGroups.index'));
        }

        return view('user__groups.edit')->with('userGroups', $userGroups);
    }

    /**
     * Update the specified User_Groups in storage.
     *
     * @param int $id
     * @param UpdateUser_GroupsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUser_GroupsRequest $request)
    {
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            Flash::error('User  Groups not found');

            return redirect(route('userGroups.index'));
        }

        $userGroups = $this->userGroupsRepository->update($request->all(), $id);

        Flash::success('User  Groups updated successfully.');

        return redirect(route('userGroups.index'));
    }

    /**
     * Remove the specified User_Groups from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userGroups = $this->userGroupsRepository->find($id);

        if (empty($userGroups)) {
            Flash::error('User  Groups not found');

            return redirect(route('userGroups.index'));
        }

        $this->userGroupsRepository->delete($id);

        Flash::success('User  Groups deleted successfully.');

        return redirect(route('userGroups.index'));
    }
}
