<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Mtest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
         //$string1 = "hello";
         //$string2= new CoroxController();
         //$string2 =$string2->about();
        $response =  $this->get('/deschool/login');
        $response->assertViewIs('login');
    }
}
