<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Repositories\CaseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CaseController extends AppBaseController
{
    /** @var  CaseRepository */
    private $caseRepository;

    public function __construct(CaseRepository $caseRepo)
    {
        $this->caseRepository = $caseRepo;
    }

    /**
     * Display a listing of the Case.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cases = $this->caseRepository->all();

        return view('cases.index')
            ->with('cases', $cases);
    }

    /**
     * Show the form for creating a new Case.
     *
     * @return Response
     */
    public function create()
    {
        return view('cases.create');
    }

    /**
     * Store a newly created Case in storage.
     *
     * @param CreateCaseRequest $request
     *
     * @return Response
     */
    public function store(CreateCaseRequest $request)
    {
        $input = $request->all();

        $case = $this->caseRepository->create($input);

        Flash::success('Case saved successfully.');

        return redirect(route('cases.index'));
    }

    /**
     * Display the specified Case.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            Flash::error('Case not found');

            return redirect(route('cases.index'));
        }

        return view('cases.show')->with('case', $case);
    }

    /**
     * Show the form for editing the specified Case.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            Flash::error('Case not found');

            return redirect(route('cases.index'));
        }

        return view('cases.edit')->with('case', $case);
    }

    /**
     * Update the specified Case in storage.
     *
     * @param int $id
     * @param UpdateCaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCaseRequest $request)
    {
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            Flash::error('Case not found');

            return redirect(route('cases.index'));
        }

        $case = $this->caseRepository->update($request->all(), $id);

        Flash::success('Case updated successfully.');

        return redirect(route('cases.index'));
    }

    /**
     * Remove the specified Case from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $case = $this->caseRepository->find($id);

        if (empty($case)) {
            Flash::error('Case not found');

            return redirect(route('cases.index'));
        }

        $this->caseRepository->delete($id);

        Flash::success('Case deleted successfully.');

        return redirect(route('cases.index'));
    }
}
