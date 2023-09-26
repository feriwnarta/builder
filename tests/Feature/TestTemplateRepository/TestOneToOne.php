<?php

namespace Tests\Feature\TestTemplateRepository;

use App\Models\TemplateRepository;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class TestOneToOne extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOneToOne(): void
    {
        $template = TemplateRepository::first()->template()->where('categories_id', '0b6e5c61-c7da-4bb5-b4e2-064ef753e1ea')->get();

        assertNotNull($template->id);
    }
}
