<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCS_ParameterRequest;
use App\Http\Requests\UpdateCS_ParameterRequest;
use App\Repositories\CS_ParameterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CS_ParameterController extends AppBaseController
{
    /** @var  CS_ParameterRepository */
    private $cSParameterRepository;

    public function __construct(CS_ParameterRepository $cSParameterRepo)
    {
        $this->cSParameterRepository = $cSParameterRepo;
    }

    /**
     * Display a listing of the CS_Parameter.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cSParameters = $this->cSParameterRepository->all();

        return view('c_s__parameters.index')
            ->with('cSParameters', $cSParameters);
    }

    /**
     * Show the form for creating a new CS_Parameter.
     *
     * @return Response
     */
    public function create()
    {
        return view('c_s__parameters.create');
    }

    /**
     * Store a newly created CS_Parameter in storage.
     *
     * @param CreateCS_ParameterRequest $request
     *
     * @return Response
     */
    public function store(CreateCS_ParameterRequest $request)
    {
        $input = $request->all();

        $cSParameter = $this->cSParameterRepository->create($input);

        Flash::success('C S  Parameter saved successfully.');

        return redirect(route('cSParameters.index'));
    }

    /**
     * Display the specified CS_Parameter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            Flash::error('C S  Parameter not found');

            return redirect(route('cSParameters.index'));
        }

        return view('c_s__parameters.show')->with('cSParameter', $cSParameter);
    }

    /**
     * Show the form for editing the specified CS_Parameter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            Flash::error('C S  Parameter not found');

            return redirect(route('cSParameters.index'));
        }

        return view('c_s__parameters.edit')->with('cSParameter', $cSParameter);
    }

    /**
     * Update the specified CS_Parameter in storage.
     *
     * @param int $id
     * @param UpdateCS_ParameterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCS_ParameterRequest $request)
    {
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            Flash::error('C S  Parameter not found');

            return redirect(route('cSParameters.index'));
        }

        $cSParameter = $this->cSParameterRepository->update($request->all(), $id);

        Flash::success('C S  Parameter updated successfully.');

        return redirect(route('cSParameters.index'));
    }

    /**
     * Remove the specified CS_Parameter from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            Flash::error('C S  Parameter not found');

            return redirect(route('cSParameters.index'));
        }

        $this->cSParameterRepository->delete($id);

        Flash::success('C S  Parameter deleted successfully.');

        return redirect(route('cSParameters.index'));
    }
}
