<?php namespace Tests\Repositories;

use App\Models\User_Groups;
use App\Repositories\User_GroupsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class User_GroupsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var User_GroupsRepository
     */
    protected $userGroupsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userGroupsRepo = \App::make(User_GroupsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user__groups()
    {
        $userGroups = factory(User_Groups::class)->make()->toArray();

        $createdUser_Groups = $this->userGroupsRepo->create($userGroups);

        $createdUser_Groups = $createdUser_Groups->toArray();
        $this->assertArrayHasKey('id', $createdUser_Groups);
        $this->assertNotNull($createdUser_Groups['id'], 'Created User_Groups must have id specified');
        $this->assertNotNull(User_Groups::find($createdUser_Groups['id']), 'User_Groups with given id must be in DB');
        $this->assertModelData($userGroups, $createdUser_Groups);
    }

    /**
     * @test read
     */
    public function test_read_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();

        $dbUser_Groups = $this->userGroupsRepo->find($userGroups->id);

        $dbUser_Groups = $dbUser_Groups->toArray();
        $this->assertModelData($userGroups->toArray(), $dbUser_Groups);
    }

    /**
     * @test update
     */
    public function test_update_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();
        $fakeUser_Groups = factory(User_Groups::class)->make()->toArray();

        $updatedUser_Groups = $this->userGroupsRepo->update($fakeUser_Groups, $userGroups->id);

        $this->assertModelData($fakeUser_Groups, $updatedUser_Groups->toArray());
        $dbUser_Groups = $this->userGroupsRepo->find($userGroups->id);
        $this->assertModelData($fakeUser_Groups, $dbUser_Groups->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user__groups()
    {
        $userGroups = factory(User_Groups::class)->create();

        $resp = $this->userGroupsRepo->delete($userGroups->id);

        $this->assertTrue($resp);
        $this->assertNull(User_Groups::find($userGroups->id), 'User_Groups should not exist in DB');
    }
}
