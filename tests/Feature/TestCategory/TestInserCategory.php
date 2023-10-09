<?php

namespace Tests\Feature\TestCategory;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class TestInserCategory extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    /**
     * A basic feature test example.
     */
    public function testInserCategory(): void
    {
        $user = User::where('fullname', 'admin')->first();

        $categoriesData = [
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Restaurants & Cafes',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Real estate',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Education',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Finance',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Healthcare',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Travel',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Fashion',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Consulting',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Entertainments',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Technology',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Sports',
                'created_by' => $user->id,
            ],
            [
                'id' => Uuid::uuid4()->toString(), // Generate UUID
                'name' => 'Organization',
                'created_by' => $user->id,
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        Category::insert($categoriesData);

        // Pastikan jumlah kategori yang dibuat sesuai dengan yang diharapkan
        $this->assertEquals(count($categoriesData), Category::count());
    }
}
