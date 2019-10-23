<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAction_TypeRequest;
use App\Http\Requests\UpdateAction_TypeRequest;
use App\Repositories\Action_TypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class Action_TypeController extends AppBaseController
{
    /** @var  Action_TypeRepository */
    private $actionTypeRepository;

    public function __construct(Action_TypeRepository $actionTypeRepo)
    {
        $this->actionTypeRepository = $actionTypeRepo;
    }

    /**
     * Display a listing of the Action_Type.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $actionTypes = $this->actionTypeRepository->all();

        return view('action__types.index')
            ->with('actionTypes', $actionTypes);
    }

    /**
     * Show the form for creating a new Action_Type.
     *
     * @return Response
     */
    public function create()
    {
        return view('action__types.create');
    }

    /**
     * Store a newly created Action_Type in storage.
     *
     * @param CreateAction_TypeRequest $request
     *
     * @return Response
     */
    public function store(CreateAction_TypeRequest $request)
    {
        $input = $request->all();

        $actionType = $this->actionTypeRepository->create($input);

        Flash::success('Action  Type saved successfully.');

        return redirect(route('actionTypes.index'));
    }

    /**
     * Display the specified Action_Type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            Flash::error('Action  Type not found');

            return redirect(route('actionTypes.index'));
        }

        return view('action__types.show')->with('actionType', $actionType);
    }

    /**
     * Show the form for editing the specified Action_Type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            Flash::error('Action  Type not found');

            return redirect(route('actionTypes.index'));
        }

        return view('action__types.edit')->with('actionType', $actionType);
    }

    /**
     * Update the specified Action_Type in storage.
     *
     * @param int $id
     * @param UpdateAction_TypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAction_TypeRequest $request)
    {
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            Flash::error('Action  Type not found');

            return redirect(route('actionTypes.index'));
        }

        $actionType = $this->actionTypeRepository->update($request->all(), $id);

        Flash::success('Action  Type updated successfully.');

        return redirect(route('actionTypes.index'));
    }

    /**
     * Remove the specified Action_Type from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $actionType = $this->actionTypeRepository->find($id);

        if (empty($actionType)) {
            Flash::error('Action  Type not found');

            return redirect(route('actionTypes.index'));
        }

        $this->actionTypeRepository->delete($id);

        Flash::success('Action  Type deleted successfully.');

        return redirect(route('actionTypes.index'));
    }
}
