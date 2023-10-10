<?php

namespace Tests\Feature\TestRegister;

use App\Livewire\LandingPage\Authentication\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TestRegisterAsUser extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRenderSuccesfully(): void
    {
        Livewire::test(Register::class)
            ->assertStatus(200);
    }

   
}
