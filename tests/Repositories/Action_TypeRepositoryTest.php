<?php namespace Tests\Repositories;

use App\Models\Action_Type;
use App\Repositories\Action_TypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Action_TypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Action_TypeRepository
     */
    protected $actionTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->actionTypeRepo = \App::make(Action_TypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_action__type()
    {
        $actionType = factory(Action_Type::class)->make()->toArray();

        $createdAction_Type = $this->actionTypeRepo->create($actionType);

        $createdAction_Type = $createdAction_Type->toArray();
        $this->assertArrayHasKey('id', $createdAction_Type);
        $this->assertNotNull($createdAction_Type['id'], 'Created Action_Type must have id specified');
        $this->assertNotNull(Action_Type::find($createdAction_Type['id']), 'Action_Type with given id must be in DB');
        $this->assertModelData($actionType, $createdAction_Type);
    }

    /**
     * @test read
     */
    public function test_read_action__type()
    {
        $actionType = factory(Action_Type::class)->create();

        $dbAction_Type = $this->actionTypeRepo->find($actionType->id);

        $dbAction_Type = $dbAction_Type->toArray();
        $this->assertModelData($actionType->toArray(), $dbAction_Type);
    }

    /**
     * @test update
     */
    public function test_update_action__type()
    {
        $actionType = factory(Action_Type::class)->create();
        $fakeAction_Type = factory(Action_Type::class)->make()->toArray();

        $updatedAction_Type = $this->actionTypeRepo->update($fakeAction_Type, $actionType->id);

        $this->assertModelData($fakeAction_Type, $updatedAction_Type->toArray());
        $dbAction_Type = $this->actionTypeRepo->find($actionType->id);
        $this->assertModelData($fakeAction_Type, $dbAction_Type->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_action__type()
    {
        $actionType = factory(Action_Type::class)->create();

        $resp = $this->actionTypeRepo->delete($actionType->id);

        $this->assertTrue($resp);
        $this->assertNull(Action_Type::find($actionType->id), 'Action_Type should not exist in DB');
    }
}
