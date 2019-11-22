<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Case;

class CaseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case()
    {
        $case = factory(Case::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cases', $case
        );

        $this->assertApiResponse($case);
    }

    /**
     * @test
     */
    public function test_read_case()
    {
        $case = factory(Case::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/cases/'.$case->id
        );

        $this->assertApiResponse($case->toArray());
    }

    /**
     * @test
     */
    public function test_update_case()
    {
        $case = factory(Case::class)->create();
        $editedCase = factory(Case::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cases/'.$case->id,
            $editedCase
        );

        $this->assertApiResponse($editedCase);
    }

    /**
     * @test
     */
    public function test_delete_case()
    {
        $case = factory(Case::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cases/'.$case->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cases/'.$case->id
        );

        $this->response->assertStatus(404);
    }
}
