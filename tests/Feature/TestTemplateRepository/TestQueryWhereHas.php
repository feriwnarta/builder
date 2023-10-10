<?php

namespace Tests\Feature\TestTemplateRepository;

use App\Models\TemplateRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class TestQueryWhereHas extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testQuery(): void
    {
        
        $id = '7cfce10a-28e7-43a7-8daf-e7053e14cc1f';
        $templates = \App\Models\Templates::join('template_repositories', 'templates.id', '=', 'template_repositories.template_id')
            ->where('templates.categories_id', $id)
            ->select('templates.title') // Gantilah '*' dengan nama kolom yang Anda butuhkan
            ->get();
    }
}
