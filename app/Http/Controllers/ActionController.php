<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActionRequest;
use App\Http\Requests\UpdateActionRequest;
use App\Repositories\ActionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ActionController extends AppBaseController
{
    /** @var  ActionRepository */
    private $actionRepository;

    public function __construct(ActionRepository $actionRepo)
    {
        $this->actionRepository = $actionRepo;
    }

    /**
     * Display a listing of the Action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $actions = $this->actionRepository->all();

        return view('actions.index')
            ->with('actions', $actions);
    }

    /**
     * Show the form for creating a new Action.
     *
     * @return Response
     */
    public function create()
    {
        return view('actions.create');
    }

    /**
     * Store a newly created Action in storage.
     *
     * @param CreateActionRequest $request
     *
     * @return Response
     */
    public function store(CreateActionRequest $request)
    {
        $input = $request->all();

        $action = $this->actionRepository->create($input);

        Flash::success('Action saved successfully.');

        return redirect(route('actions.index'));
    }

    /**
     * Display the specified Action.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            Flash::error('Action not found');

            return redirect(route('actions.index'));
        }

        return view('actions.show')->with('action', $action);
    }

    /**
     * Show the form for editing the specified Action.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            Flash::error('Action not found');

            return redirect(route('actions.index'));
        }

        return view('actions.edit')->with('action', $action);
    }

    /**
     * Update the specified Action in storage.
     *
     * @param int $id
     * @param UpdateActionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActionRequest $request)
    {
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            Flash::error('Action not found');

            return redirect(route('actions.index'));
        }

        $action = $this->actionRepository->update($request->all(), $id);

        Flash::success('Action updated successfully.');

        return redirect(route('actions.index'));
    }

    /**
     * Remove the specified Action from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $action = $this->actionRepository->find($id);

        if (empty($action)) {
            Flash::error('Action not found');

            return redirect(route('actions.index'));
        }

        $this->actionRepository->delete($id);

        Flash::success('Action deleted successfully.');

        return redirect(route('actions.index'));
    }
}
