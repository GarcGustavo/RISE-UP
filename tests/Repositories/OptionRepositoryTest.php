<?php namespace Tests\Repositories;

use App\Models\Option;
use App\Repositories\OptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OptionRepository
     */
    protected $optionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->optionRepo = \App::make(OptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_option()
    {
        $option = factory(Option::class)->make()->toArray();

        $createdOption = $this->optionRepo->create($option);

        $createdOption = $createdOption->toArray();
        $this->assertArrayHasKey('id', $createdOption);
        $this->assertNotNull($createdOption['id'], 'Created Option must have id specified');
        $this->assertNotNull(Option::find($createdOption['id']), 'Option with given id must be in DB');
        $this->assertModelData($option, $createdOption);
    }

    /**
     * @test read
     */
    public function test_read_option()
    {
        $option = factory(Option::class)->create();

        $dbOption = $this->optionRepo->find($option->id);

        $dbOption = $dbOption->toArray();
        $this->assertModelData($option->toArray(), $dbOption);
    }

    /**
     * @test update
     */
    public function test_update_option()
    {
        $option = factory(Option::class)->create();
        $fakeOption = factory(Option::class)->make()->toArray();

        $updatedOption = $this->optionRepo->update($fakeOption, $option->id);

        $this->assertModelData($fakeOption, $updatedOption->toArray());
        $dbOption = $this->optionRepo->find($option->id);
        $this->assertModelData($fakeOption, $dbOption->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_option()
    {
        $option = factory(Option::class)->create();

        $resp = $this->optionRepo->delete($option->id);

        $this->assertTrue($resp);
        $this->assertNull(Option::find($option->id), 'Option should not exist in DB');
    }
}
