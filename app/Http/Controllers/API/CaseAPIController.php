<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseAPIRequest;
use App\Http\Requests\API\UpdateCaseAPIRequest;
use App\Models\Case;
use App\Repositories\CaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CaseController
 * @package App\Http\Controllers\API
 */

class CaseAPIController extends AppBaseController
{
    /** @var  CaseRepository */
    private $caseRepository;

    public function __construct(CaseRepository $caseRepo)
    {
        $this->caseRepository = $caseRepo;
    }

    /**
     * Display a listing of the Case.
     * GET|HEAD /cases
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cases = $this->caseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cases->toArray(), 'Cases retrieved successfully');
    }

    /**
     * Store a newly created Case in storage.
     * POST /cases
     *
     * @param CreateCaseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCaseAPIRequest $request)
    {
        $input = $request->all();

        $case = $this->caseRepository->create($input);

        return $this->sendResponse($case->toArray(), 'Case saved successfully');
    }

    /**
     * Display the specified Case.
     * GET|HEAD /cases/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Case $case */
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            return $this->sendError('Case not found');
        }

        return $this->sendResponse($case->toArray(), 'Case retrieved successfully');
    }

    /**
     * Update the specified Case in storage.
     * PUT/PATCH /cases/{id}
     *
     * @param int $id
     * @param UpdateCaseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCaseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Case $case */
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            return $this->sendError('Case not found');
        }

        $case = $this->caseRepository->update($input, $id);

        return $this->sendResponse($case->toArray(), 'Case updated successfully');
    }

    /**
     * Remove the specified Case from storage.
     * DELETE /cases/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Case $case */
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            return $this->sendError('Case not found');
        }

        $case->delete();

        return $this->sendResponse($id, 'Case deleted successfully');
    }
}
