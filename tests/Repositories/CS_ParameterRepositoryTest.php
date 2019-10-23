<?php namespace Tests\Repositories;

use App\Models\CS_Parameter;
use App\Repositories\CS_ParameterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CS_ParameterRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CS_ParameterRepository
     */
    protected $cSParameterRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cSParameterRepo = \App::make(CS_ParameterRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->make()->toArray();

        $createdCS_Parameter = $this->cSParameterRepo->create($cSParameter);

        $createdCS_Parameter = $createdCS_Parameter->toArray();
        $this->assertArrayHasKey('id', $createdCS_Parameter);
        $this->assertNotNull($createdCS_Parameter['id'], 'Created CS_Parameter must have id specified');
        $this->assertNotNull(CS_Parameter::find($createdCS_Parameter['id']), 'CS_Parameter with given id must be in DB');
        $this->assertModelData($cSParameter, $createdCS_Parameter);
    }

    /**
     * @test read
     */
    public function test_read_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();

        $dbCS_Parameter = $this->cSParameterRepo->find($cSParameter->id);

        $dbCS_Parameter = $dbCS_Parameter->toArray();
        $this->assertModelData($cSParameter->toArray(), $dbCS_Parameter);
    }

    /**
     * @test update
     */
    public function test_update_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();
        $fakeCS_Parameter = factory(CS_Parameter::class)->make()->toArray();

        $updatedCS_Parameter = $this->cSParameterRepo->update($fakeCS_Parameter, $cSParameter->id);

        $this->assertModelData($fakeCS_Parameter, $updatedCS_Parameter->toArray());
        $dbCS_Parameter = $this->cSParameterRepo->find($cSParameter->id);
        $this->assertModelData($fakeCS_Parameter, $dbCS_Parameter->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();

        $resp = $this->cSParameterRepo->delete($cSParameter->id);

        $this->assertTrue($resp);
        $this->assertNull(CS_Parameter::find($cSParameter->id), 'CS_Parameter should not exist in DB');
    }
}
