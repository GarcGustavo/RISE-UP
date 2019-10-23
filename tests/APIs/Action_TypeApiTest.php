<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Action_Type;

class Action_TypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_action__type()
    {
        $actionType = factory(Action_Type::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/action__types', $actionType
        );

        $this->assertApiResponse($actionType);
    }

    /**
     * @test
     */
    public function test_read_action__type()
    {
        $actionType = factory(Action_Type::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/action__types/'.$actionType->id
        );

        $this->assertApiResponse($actionType->toArray());
    }

    /**
     * @test
     */
    public function test_update_action__type()
    {
        $actionType = factory(Action_Type::class)->create();
        $editedAction_Type = factory(Action_Type::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/action__types/'.$actionType->id,
            $editedAction_Type
        );

        $this->assertApiResponse($editedAction_Type);
    }

    /**
     * @test
     */
    public function test_delete_action__type()
    {
        $actionType = factory(Action_Type::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/action__types/'.$actionType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/action__types/'.$actionType->id
        );

        $this->response->assertStatus(404);
    }
}
