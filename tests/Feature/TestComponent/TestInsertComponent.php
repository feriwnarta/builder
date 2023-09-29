<?php

namespace Tests\Feature\TestComponent;

use App\Models\Component;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

class TestInsertComponent extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from components');
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $componentData = [
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'component_categories_id' => '7b3c6123-cc19-40e7-bfbb-3e3d5e81e8b8',
                'label' => '1 Row 1 Column',
                'media' => '',
                'content' => '<h1>1 Row 1 Column</h1>'

            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'component_categories_id' => '7b3c6123-cc19-40e7-bfbb-3e3d5e81e8b8',
                'label' => '1 Row 2 Column',
                'media' => '',
                'content' => '<h1>1 Row 2 Column</h1>'

            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'component_categories_id' => '7b3c6123-cc19-40e7-bfbb-3e3d5e81e8b8',
                'label' => '1 Row 3 Column',
                'media' => '',
                'content' => '<h1>1 Row 3 Column</h1>'

            ]

        ];

        $component = Component::insert($componentData);

        $this->assertEquals(count($componentData), Component::count());
    }
}
