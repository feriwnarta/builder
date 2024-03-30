<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserTemplate;
use App\Models\UserWebsite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TemplateControllerTest extends TestCase
{
    public function testPublishSuccess()
    {

        $result = $this->post('/publish', [
            'html' => fake()->randomHtml,
            'css' => fake()->randomHtml,
            'id' => UserTemplate::first()->id,
            'user_id' => User::first()->id,
        ])->assertStatus(201);
    }

    public function testPublishFailed()
    {
        $this->actingAs(User::first());

        $result = $this->post('/publish', [
            'css' => fake()->randomHtml,
            'id' => UserTemplate::first()->id,
        ])->assertStatus(400);
    }

}
