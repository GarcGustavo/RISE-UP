<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User_Groups;

class User_GroupsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user__groups()
    {
        $userGroups = factory(User_Groups::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user__groups', $userGroups
        );

        $this->assertApiResponse($userGroups);
    }

    /**
     * @test
     */
    public function test_read_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user__groups/'.$userGroups->id
        );

        $this->assertApiResponse($userGroups->toArray());
    }

    /**
     * @test
     */
    public function test_update_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();
        $editedUser_Groups = factory(User_Groups::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user__groups/'.$userGroups->id,
            $editedUser_Groups
        );

        $this->assertApiResponse($editedUser_Groups);
    }

    /**
     * @test
     */
    public function test_delete_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user__groups/'.$userGroups->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user__groups/'.$userGroups->id
        );

        $this->response->assertStatus(404);
    }
}
