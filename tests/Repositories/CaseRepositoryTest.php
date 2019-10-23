<?php namespace Tests\Repositories;

use App\Models\Case;
use App\Repositories\CaseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CaseRepository
     */
    protected $caseRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseRepo = \App::make(CaseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case()
    {
        $case = factory(Case::class)->make()->toArray();

        $createdCase = $this->caseRepo->create($case);

        $createdCase = $createdCase->toArray();
        $this->assertArrayHasKey('id', $createdCase);
        $this->assertNotNull($createdCase['id'], 'Created Case must have id specified');
        $this->assertNotNull(Case::find($createdCase['id']), 'Case with given id must be in DB');
        $this->assertModelData($case, $createdCase);
    }

    /**
     * @test read
     */
    public function test_read_case()
    {
        $case = factory(Case::class)->create();

        $dbCase = $this->caseRepo->find($case->id);

        $dbCase = $dbCase->toArray();
        $this->assertModelData($case->toArray(), $dbCase);
    }

    /**
     * @test update
     */
    public function test_update_case()
    {
        $case = factory(Case::class)->create();
        $fakeCase = factory(Case::class)->make()->toArray();

        $updatedCase = $this->caseRepo->update($fakeCase, $case->id);

        $this->assertModelData($fakeCase, $updatedCase->toArray());
        $dbCase = $this->caseRepo->find($case->id);
        $this->assertModelData($fakeCase, $dbCase->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case()
    {
        $case = factory(Case::class)->create();

        $resp = $this->caseRepo->delete($case->id);

        $this->assertTrue($resp);
        $this->assertNull(Case::find($case->id), 'Case should not exist in DB');
    }
}
