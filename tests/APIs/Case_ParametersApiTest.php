<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Case_Parameters;

class Case_ParametersApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case__parameters', $caseParameters
        );

        $this->assertApiResponse($caseParameters);
    }

    /**
     * @test
     */
    public function test_read_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/case__parameters/'.$caseParameters->id
        );

        $this->assertApiResponse($caseParameters->toArray());
    }

    /**
     * @test
     */
    public function test_update_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();
        $editedCase_Parameters = factory(Case_Parameters::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case__parameters/'.$caseParameters->id,
            $editedCase_Parameters
        );

        $this->assertApiResponse($editedCase_Parameters);
    }

    /**
     * @test
     */
    public function test_delete_case__parameters()
    {
        $caseParameters = factory(Case_Parameters::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case__parameters/'.$caseParameters->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case__parameters/'.$caseParameters->id
        );

        $this->response->assertStatus(404);
    }
}
