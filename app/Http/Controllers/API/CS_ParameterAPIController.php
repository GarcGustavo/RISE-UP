<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCS_ParameterAPIRequest;
use App\Http\Requests\API\UpdateCS_ParameterAPIRequest;
use App\Models\CS_Parameter;
use App\Repositories\CS_ParameterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CS_ParameterController
 * @package App\Http\Controllers\API
 */

class CS_ParameterAPIController extends AppBaseController
{
    /** @var  CS_ParameterRepository */
    private $cSParameterRepository;

    public function __construct(CS_ParameterRepository $cSParameterRepo)
    {
        $this->cSParameterRepository = $cSParameterRepo;
    }

    /**
     * Display a listing of the CS_Parameter.
     * GET|HEAD /cSParameters
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cSParameters = $this->cSParameterRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cSParameters->toArray(), 'C S  Parameters retrieved successfully');
    }

    /**
     * Store a newly created CS_Parameter in storage.
     * POST /cSParameters
     *
     * @param CreateCS_ParameterAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCS_ParameterAPIRequest $request)
    {
        $input = $request->all();

        $cSParameter = $this->cSParameterRepository->create($input);

        return $this->sendResponse($cSParameter->toArray(), 'C S  Parameter saved successfully');
    }

    /**
     * Display the specified CS_Parameter.
     * GET|HEAD /cSParameters/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CS_Parameter $cSParameter */
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            return $this->sendError('C S  Parameter not found');
        }

        return $this->sendResponse($cSParameter->toArray(), 'C S  Parameter retrieved successfully');
    }

    /**
     * Update the specified CS_Parameter in storage.
     * PUT/PATCH /cSParameters/{id}
     *
     * @param int $id
     * @param UpdateCS_ParameterAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCS_ParameterAPIRequest $request)
    {
        $input = $request->all();

        /** @var CS_Parameter $cSParameter */
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            return $this->sendError('C S  Parameter not found');
        }

        $cSParameter = $this->cSParameterRepository->update($input, $id);

        return $this->sendResponse($cSParameter->toArray(), 'CS_Parameter updated successfully');
    }

    /**
     * Remove the specified CS_Parameter from storage.
     * DELETE /cSParameters/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CS_Parameter $cSParameter */
        $cSParameter = $this->cSParameterRepository->find($id);

        if (empty($cSParameter)) {
            return $this->sendError('C S  Parameter not found');
        }

        $cSParameter->delete();

        return $this->sendResponse($id, 'C S  Parameter deleted successfully');
    }
}
