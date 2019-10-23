<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCase_ParametersAPIRequest;
use App\Http\Requests\API\UpdateCase_ParametersAPIRequest;
use App\Models\Case_Parameters;
use App\Repositories\Case_ParametersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Case_ParametersController
 * @package App\Http\Controllers\API
 */

class Case_ParametersAPIController extends AppBaseController
{
    /** @var  Case_ParametersRepository */
    private $caseParametersRepository;

    public function __construct(Case_ParametersRepository $caseParametersRepo)
    {
        $this->caseParametersRepository = $caseParametersRepo;
    }

    /**
     * Display a listing of the Case_Parameters.
     * GET|HEAD /caseParameters
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $caseParameters = $this->caseParametersRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($caseParameters->toArray(), 'Case  Parameters retrieved successfully');
    }

    /**
     * Store a newly created Case_Parameters in storage.
     * POST /caseParameters
     *
     * @param CreateCase_ParametersAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCase_ParametersAPIRequest $request)
    {
        $input = $request->all();

        $caseParameters = $this->caseParametersRepository->create($input);

        return $this->sendResponse($caseParameters->toArray(), 'Case  Parameters saved successfully');
    }

    /**
     * Display the specified Case_Parameters.
     * GET|HEAD /caseParameters/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Case_Parameters $caseParameters */
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            return $this->sendError('Case  Parameters not found');
        }

        return $this->sendResponse($caseParameters->toArray(), 'Case  Parameters retrieved successfully');
    }

    /**
     * Update the specified Case_Parameters in storage.
     * PUT/PATCH /caseParameters/{id}
     *
     * @param int $id
     * @param UpdateCase_ParametersAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCase_ParametersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Case_Parameters $caseParameters */
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            return $this->sendError('Case  Parameters not found');
        }

        $caseParameters = $this->caseParametersRepository->update($input, $id);

        return $this->sendResponse($caseParameters->toArray(), 'Case_Parameters updated successfully');
    }

    /**
     * Remove the specified Case_Parameters from storage.
     * DELETE /caseParameters/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Case_Parameters $caseParameters */
        $caseParameters = $this->caseParametersRepository->find($id);

        if (empty($caseParameters)) {
            return $this->sendError('Case  Parameters not found');
        }

        $caseParameters->delete();

        return $this->sendResponse($id, 'Case  Parameters deleted successfully');
    }
}
