<?php namespace Tests\Repositories;

use App\Models\Item_Type;
use App\Repositories\Item_TypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Item_TypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Item_TypeRepository
     */
    protected $itemTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->itemTypeRepo = \App::make(Item_TypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_item__type()
    {
        $itemType = factory(Item_Type::class)->make()->toArray();

        $createdItem_Type = $this->itemTypeRepo->create($itemType);

        $createdItem_Type = $createdItem_Type->toArray();
        $this->assertArrayHasKey('id', $createdItem_Type);
        $this->assertNotNull($createdItem_Type['id'], 'Created Item_Type must have id specified');
        $this->assertNotNull(Item_Type::find($createdItem_Type['id']), 'Item_Type with given id must be in DB');
        $this->assertModelData($itemType, $createdItem_Type);
    }

    /**
     * @test read
     */
    public function test_read_item__type()
    {
        $itemType = factory(Item_Type::class)->create();

        $dbItem_Type = $this->itemTypeRepo->find($itemType->id);

        $dbItem_Type = $dbItem_Type->toArray();
        $this->assertModelData($itemType->toArray(), $dbItem_Type);
    }

    /**
     * @test update
     */
    public function test_update_item__type()
    {
        $itemType = factory(Item_Type::class)->create();
        $fakeItem_Type = factory(Item_Type::class)->make()->toArray();

        $updatedItem_Type = $this->itemTypeRepo->update($fakeItem_Type, $itemType->id);

        $this->assertModelData($fakeItem_Type, $updatedItem_Type->toArray());
        $dbItem_Type = $this->itemTypeRepo->find($itemType->id);
        $this->assertModelData($fakeItem_Type, $dbItem_Type->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_item__type()
    {
        $itemType = factory(Item_Type::class)->create();

        $resp = $this->itemTypeRepo->delete($itemType->id);

        $this->assertTrue($resp);
        $this->assertNull(Item_Type::find($itemType->id), 'Item_Type should not exist in DB');
    }
}
