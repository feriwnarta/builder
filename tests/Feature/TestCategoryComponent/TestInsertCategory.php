<?php

namespace Tests\Feature\TestCategoryComponent;

use App\Models\ComponentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class TestInsertCategory extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertCategory(): void
    {
        $categoriesData = [
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Structure',
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Form',
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Typhography',
            ],
        ];

        ComponentCategory::insert($categoriesData);

        // Category::insert($categoriesData);

        // Pastikan jumlah kategori yang dibuat sesuai dengan yang diharapkan
        $this->assertEquals(count($categoriesData), ComponentCategory::count());
    }
}
