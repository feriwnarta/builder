<?php

namespace Tests\Feature\TestRegisterLivewire;

use App\Livewire\LandingPage\Authentication\Register;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TestRegisterAsUser extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testRenderSuccesfully(): void
    {
        Livewire::test(Register::class)
            ->assertStatus(200);
    }

    /**
     * @return void
     * test register sebagai user
     */
    public function testUserRegister(): void
    {

        Livewire::test(Register::class)->set('name', fake()->name())->set('email', fake()->email())->set('password', fake()->password())->call('save')->assertRedirect('/dashboard');

    }

    /**
     * @return void
     * test validasi name dibawah dari 5 karakter
     */
    public function testFailureUserRegisterNameNotValid(): void
    {
        Livewire::test(Register::class)->set('name', 'krg')->set('email', fake()->email())->set('password', fake()->password())->call('save')->assertNoRedirect()->assertSee('The name field must be at least 5 characters.');
    }


    public function testFailureUserRegisterEmailNotValid(): void
    {
        Livewire::test(Register::class)->set('name', fake()->name())->set('email', 'agmail.com')->set('password', fake()->password())->call('save')->assertNoRedirect()->assertSee('The email field must be a valid email address.');
    }


}
