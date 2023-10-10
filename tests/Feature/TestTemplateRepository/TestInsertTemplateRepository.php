<?php

namespace Tests\Feature\TestTemplateRepository;

use App\Models\TemplateRepository;
use App\Models\Templates;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Template\Template;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TestInsertTemplateRepository extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertTemplateRestaurant(): void
    {

        $template = Templates::where('categories_id', '7cfce10a-28e7-43a7-8daf-e7053e14cc1f')->first();

        $result = TemplateRepository::create([
            'template_id' => $template->id,
            'type' => 'Ready for sale'
        ]);

        assertEquals($result->type, 'Ready for sale');
    }
}
