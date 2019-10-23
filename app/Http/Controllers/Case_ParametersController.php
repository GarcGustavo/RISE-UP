<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCase_ParametersRequest;
use App\Http\Requests\UpdateCase_ParametersRequest;
use App\Repositories\Case_ParametersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class Case_ParametersController extends AppBaseController
{
    /** @var  Case_ParametersRepository */
    private $caseParametersRepository;

    public function __construct(Case_ParametersRepository $caseParametersRepo)
    {
        $this->caseParametersRepository = $caseParametersRepo;
    }

    /**
     * Display a listing of the Case_Parameters.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $caseParameters = $this->caseParametersRepository->all();

        return view('case__parameters.index')
            ->with('caseParameters', $caseParameters);
    }

    /**
     * Show the form for creating a new Case_Parameters.
     *
     * @return Response
     */
    public function create()
    {
        return view('case__parameters.create');
    }

    /**
     * Store a newly created Case_Parameters in storage.
     *
     * @param CreateCase_ParametersRequest $request
     *
     * @return Response
     */
    public function store(CreateCase_ParametersRequest $request)
    {
        $input = $request->all();

        $caseParameters = $this->caseParametersRepository->create($input);

        Flash::success('Case  Parameters saved successfully.');

        return redirect(route('caseParameters.index'));
    }

    /**
     * Display the specified Case_Parameters.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            Flash::error('Case  Parameters not found');

            return redirect(route('caseParameters.index'));
        }

        return view('case__parameters.show')->with('caseParameters', $caseParameters);
    }

    /**
     * Show the form for editing the specified Case_Parameters.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            Flash::error('Case  Parameters not found');

            return redirect(route('caseParameters.index'));
        }

        return view('case__parameters.edit')->with('caseParameters', $caseParameters);
    }

    /**
     * Update the specified Case_Parameters in storage.
     *
     * @param int $id
     * @param UpdateCase_ParametersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCase_ParametersRequest $request)
    {
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            Flash::error('Case  Parameters not found');

            return redirect(route('caseParameters.index'));
        }

        $caseParameters = $this->caseParametersRepository->update($request->all(), $id);

        Flash::success('Case  Parameters updated successfully.');

        return redirect(route('caseParameters.index'));
    }

    /**
     * Remove the specified Case_Parameters from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            Flash::error('Case  Parameters not found');

            return redirect(route('caseParameters.index'));
        }

        $this->caseParametersRepository->delete($id);

        Flash::success('Case  Parameters deleted successfully.');

        return redirect(route('caseParameters.index'));
    }
}
