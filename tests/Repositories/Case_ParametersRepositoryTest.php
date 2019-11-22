<?php namespace Tests\Repositories;

use App\Models\Case_Parameters;
use App\Repositories\Case_ParametersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Case_ParametersRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Case_ParametersRepository
     */
    protected $caseParametersRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseParametersRepo = \App::make(Case_ParametersRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->make()->toArray();

        $createdCase_Parameters = $this->caseParametersRepo->create($caseParameters);

        $createdCase_Parameters = $createdCase_Parameters->toArray();
        $this->assertArrayHasKey('id', $createdCase_Parameters);
        $this->assertNotNull($createdCase_Parameters['id'], 'Created Case_Parameters must have id specified');
        $this->assertNotNull(Case_Parameters::find($createdCase_Parameters['id']), 'Case_Parameters with given id must be in DB');
        $this->assertModelData($caseParameters, $createdCase_Parameters);
    }

    /**
     * @test read
     */
    public function test_read_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();

        $dbCase_Parameters = $this->caseParametersRepo->find($caseParameters->id);

        $dbCase_Parameters = $dbCase_Parameters->toArray();
        $this->assertModelData($caseParameters->toArray(), $dbCase_Parameters);
    }

    /**
     * @test update
     */
    public function test_update_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();
        $fakeCase_Parameters = factory(Case_Parameters::class)->make()->toArray();

        $updatedCase_Parameters = $this->caseParametersRepo->update($fakeCase_Parameters, $caseParameters->id);

        $this->assertModelData($fakeCase_Parameters, $updatedCase_Parameters->toArray());
        $dbCase_Parameters = $this->caseParametersRepo->find($caseParameters->id);
        $this->assertModelData($fakeCase_Parameters, $dbCase_Parameters->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();

        $resp = $this->caseParametersRepo->delete($caseParameters->id);

        $this->assertTrue($resp);
        $this->assertNull(Case_Parameters::find($caseParameters->id), 'Case_Parameters should not exist in DB');
    }
}
