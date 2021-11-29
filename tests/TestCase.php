<?php

namespace Tests;
use App\Basket;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function testExample (){
             $this->assertTrue(true);
    }


}
