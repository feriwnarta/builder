<?php

namespace Tests\Feature\TestTemplate;

use App\Models\Category;
use App\Models\Templates;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Template\Template;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class TestInsertTemplate extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertTemplate(): void
    {
        $user = User::first();
        $categories = Category::where('name', 'Consulting')->first();

        $template = Templates::create([
            'data' => 'data',
            'title' => 'Resto',
            'categories_id' => $categories->id,
            'subtitle' => 'Discover our unique flavors and warm ambiance.',
            'user_id' => $user->id, 
            'thumbnail' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1CX_abGMl_NrRf4RvUHyOH1JkE947laxwI7lh776Wfw&s',
            'type' => 'create',
        ]);

        assertEquals('Resto', $template->title);
    }

    // public function testQueryGetTemplateByUserId()
    // {
    //     $template = Templates::findOrFail('9a395d75-0248-447b-aedb-7fcfe88948de')->user();

    //     assertEquals('feri', $template->name);
    // }
}
