<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\Citation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PegueControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_citation_endpoint_is_reachable(): void
    {
        $this->markTestSkipped('not doing api key in workflow');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('api/v1/citation', ['citation' => 'Ivanovic, J., Baltic, M. Z., Janjic, J., Markovic, R., Baltic, T., Boskovic, M., ... & Jovanovic, D. (2016). Health aspects of dry-cured ham. Scientific journal" Meat Technology", 57(1), 43-50.']);
        $response->assertStatus(200);

        dump(Citation::get());
    }

    public function test_citation_endpoint_is_not_reachable_by_logged_out_users(): void
    {
        //  $this->markTestSkipped('not doing api key in workflow');
        $response = $this->post('api/v1/citation', ['citation' => 'Ivanovic, J., Baltic, M. Z., Janjic, J., Markovic, R., Baltic, T., Boskovic, M., ... & Jovanovic, D. (2016). Health aspects of dry-cured ham. Scientific journal" Meat Technology", 57(1), 43-50.']);
        $response->assertStatus(302);
    }

    public function test_api_post_request_resolves(): void
    {
        $citations = Storage::disk('local')->get('test.citations.json');
        $citations = json_decode($citations, true);
        $user = User::factory()->create();

        foreach ($citations as $citation) {
            $citation = json_encode($citation);
            $response = $this->actingAs($user)
                ->post('api/v1/citation', ['test' => $citation]);
            $response->assertStatus(200);
        }
    }

    public function test_api_post_request_saves_data(): void
    {
        $citations = Storage::disk('local')->get('test.citations.json');
        $citations = json_decode($citations, true);
        $user = User::factory()->create();

        for ($i = 0; $i < count($citations); $i++) {
            $citation = json_encode($citations[$i]);
            $this->actingAs($user)
                ->post('api/v1/citation', ['test' => $citation]);
        }

        $testCitations = Citation::all();

        for ($i = 0; $i < count($testCitations); $i++) {
            $test = json_decode($testCitations[$i]->citation, true);
            $this->assertEquals($citations[$i], $test);
        }
    }
}
