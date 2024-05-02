<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/api/stock');
        $stocks = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertEquals('TSMC', $stocks[0]['name']);
    }
}
