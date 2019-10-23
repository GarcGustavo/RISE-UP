<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMigrationsRequest;
use App\Http\Requests\UpdateMigrationsRequest;
use App\Repositories\MigrationsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class MigrationsController extends AppBaseController
{
    /** @var  MigrationsRepository */
    private $migrationsRepository;

    public function __construct(MigrationsRepository $migrationsRepo)
    {
        $this->migrationsRepository = $migrationsRepo;
    }

    /**
     * Display a listing of the Migrations.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $migrations = $this->migrationsRepository->all();

        return view('migrations.index')
            ->with('migrations', $migrations);
    }

    /**
     * Show the form for creating a new Migrations.
     *
     * @return Response
     */
    public function create()
    {
        return view('migrations.create');
    }

    /**
     * Store a newly created Migrations in storage.
     *
     * @param CreateMigrationsRequest $request
     *
     * @return Response
     */
    public function store(CreateMigrationsRequest $request)
    {
        $input = $request->all();

        $migrations = $this->migrationsRepository->create($input);

        Flash::success('Migrations saved successfully.');

        return redirect(route('migrations.index'));
    }

    /**
     * Display the specified Migrations.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            Flash::error('Migrations not found');

            return redirect(route('migrations.index'));
        }

        return view('migrations.show')->with('migrations', $migrations);
    }

    /**
     * Show the form for editing the specified Migrations.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            Flash::error('Migrations not found');

            return redirect(route('migrations.index'));
        }

        return view('migrations.edit')->with('migrations', $migrations);
    }

    /**
     * Update the specified Migrations in storage.
     *
     * @param int $id
     * @param UpdateMigrationsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMigrationsRequest $request)
    {
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            Flash::error('Migrations not found');

            return redirect(route('migrations.index'));
        }

        $migrations = $this->migrationsRepository->update($request->all(), $id);

        Flash::success('Migrations updated successfully.');

        return redirect(route('migrations.index'));
    }

    /**
     * Remove the specified Migrations from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            Flash::error('Migrations not found');

            return redirect(route('migrations.index'));
        }

        $this->migrationsRepository->delete($id);

        Flash::success('Migrations deleted successfully.');

        return redirect(route('migrations.index'));
    }
}
