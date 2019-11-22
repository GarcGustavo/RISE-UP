<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CS_Parameter;

class CS_ParameterApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/c_s__parameters', $cSParameter
        );

        $this->assertApiResponse($cSParameter);
    }

    /**
     * @test
     */
    public function test_read_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/c_s__parameters/'.$cSParameter->id
        );

        $this->assertApiResponse($cSParameter->toArray());
    }

    /**
     * @test
     */
    public function test_update_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();
        $editedCS_Parameter = factory(CS_Parameter::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/c_s__parameters/'.$cSParameter->id,
            $editedCS_Parameter
        );

        $this->assertApiResponse($editedCS_Parameter);
    }

    /**
     * @test
     */
    public function test_delete_c_s__parameter()
    {
        $cSParameter = factory(CS_Parameter::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/c_s__parameters/'.$cSParameter->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/c_s__parameters/'.$cSParameter->id
        );

        $this->response->assertStatus(404);
    }
}
