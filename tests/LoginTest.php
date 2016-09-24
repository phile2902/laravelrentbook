<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_page(){ 
        $this->visit('login')
                ->type('phi2902@yahoo.com', 'email')
                ->type('123456', 'password')
                ->press('Login')
                ->seePageIs('/');
        }
        
    public function test_login_be_this_user(){
        $user = App\User::first();
        $this->be($user);
    }
}
