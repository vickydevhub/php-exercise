<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_displays_the_search_form()
    {
        $response = $this->get(route('home'));
    
        $response->assertStatus(200);
        $response->assertViewIs('form');
    }

    /** @test */
    public function search_displays_validation_errors()
    {
        $response = $this->get('/search', []);
    
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email','start_date','end_date','company_symbol']);
    }

    /** @test */
    public function search_api_data()
    {
        $response = $this->get('/search', [
            'email' =>  'test@gmail.com',
            'start_date' => '04/07/2022',
            'end_date' => '05/07/2022',
            'company_symbol' => 'AAPL'
        ]);
     
        $response->assertStatus(200);
        $response->assertViewIs('data');
    }

    public function testEmailGetsSentSuccess()
    {
         

        $emails = app()->make('swift.transport')->driver()->messages();
        $this->assertEmpty($emails);

         

        $emails = app()->make('swift.transport')->driver()->messages();
        $this->assertNotEmpty($emails);

        $this->assertContains('Some Subject', $emails[0]->getSubject());
        $this->assertEquals('someone@example.com', array_keys($emails[0]->getTo())[0]);
    }
}
