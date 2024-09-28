<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CitationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_saves_data_correctly(): void
    {
        $this->markTestIncomplete();
        $citations = Storage::disk('local')->get('test.citations.json');
        $citations = json_decode($citations, true);
    }
}
