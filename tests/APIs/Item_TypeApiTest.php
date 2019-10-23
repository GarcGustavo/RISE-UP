<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Item_Type;

class Item_TypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_item__type()
    {
        $itemType = factory(Item_Type::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/item__types', $itemType
        );

        $this->assertApiResponse($itemType);
    }

    /**
     * @test
     */
    public function test_read_item__type()
    {
        $itemType = factory(Item_Type::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/item__types/'.$itemType->id
        );

        $this->assertApiResponse($itemType->toArray());
    }

    /**
     * @test
     */
    public function test_update_item__type()
    {
        $itemType = factory(Item_Type::class)->create();
        $editedItem_Type = factory(Item_Type::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/item__types/'.$itemType->id,
            $editedItem_Type
        );

        $this->assertApiResponse($editedItem_Type);
    }

    /**
     * @test
     */
    public function test_delete_item__type()
    {
        $itemType = factory(Item_Type::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/item__types/'.$itemType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/item__types/'.$itemType->id
        );

        $this->response->assertStatus(404);
    }
}
