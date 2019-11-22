<?php namespace Tests\Repositories;

use App\Models\Action;
use App\Repositories\ActionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ActionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ActionRepository
     */
    protected $actionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->actionRepo = \App::make(ActionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_action()
    {
        $action = factory(Action::class)->make()->toArray();

        $createdAction = $this->actionRepo->create($action);

        $createdAction = $createdAction->toArray();
        $this->assertArrayHasKey('id', $createdAction);
        $this->assertNotNull($createdAction['id'], 'Created Action must have id specified');
        $this->assertNotNull(Action::find($createdAction['id']), 'Action with given id must be in DB');
        $this->assertModelData($action, $createdAction);
    }

    /**
     * @test read
     */
    public function test_read_action()
    {
        $action = factory(Action::class)->create();

        $dbAction = $this->actionRepo->find($action->id);

        $dbAction = $dbAction->toArray();
        $this->assertModelData($action->toArray(), $dbAction);
    }

    /**
     * @test update
     */
    public function test_update_action()
    {
        $action = factory(Action::class)->create();
        $fakeAction = factory(Action::class)->make()->toArray();

        $updatedAction = $this->actionRepo->update($fakeAction, $action->id);

        $this->assertModelData($fakeAction, $updatedAction->toArray());
        $dbAction = $this->actionRepo->find($action->id);
        $this->assertModelData($fakeAction, $dbAction->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_action()
    {
        $action = factory(Action::class)->create();

        $resp = $this->actionRepo->delete($action->id);

        $this->assertTrue($resp);
        $this->assertNull(Action::find($action->id), 'Action should not exist in DB');
    }
}
