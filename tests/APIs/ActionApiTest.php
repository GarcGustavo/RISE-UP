<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Action;

class ActionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_action()
    {
        $action = factory(Action::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/actions', $action
        );

        $this->assertApiResponse($action);
    }

    /**
     * @test
     */
    public function test_read_action()
    {
        $action = factory(Action::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/actions/'.$action->id
        );

        $this->assertApiResponse($action->toArray());
    }

    /**
     * @test
     */
    public function test_update_action()
    {
        $action = factory(Action::class)->create();
        $editedAction = factory(Action::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/actions/'.$action->id,
            $editedAction
        );

        $this->assertApiResponse($editedAction);
    }

    /**
     * @test
     */
    public function test_delete_action()
    {
        $action = factory(Action::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/actions/'.$action->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/actions/'.$action->id
        );

        $this->response->assertStatus(404);
    }
}
