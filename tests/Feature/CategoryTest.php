<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_category_screen_can_be_rendered()
    {
        $this->user();
        $response = $this->get('/category');

        $response->assertStatus(200);
    }

    public function test_category_form_can_be_rendered()
    {
        $this->user();
        $response = $this->get('/category/create');
        $response->assertStatus(200);
    }

    public function test_category_can_be_stored_into_database()
    {
        $this->user();
        $this->post('/category/create', [
            'name' => $this->faker()->name(),
        ]);
        $this->assertDatabaseCount('categories', 1);
    }

    public function user()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $this->assertAuthenticated();
    }

    public function test_category_can_be_updated()
    {
        $this->user();
        $categories =  Category::first();
        $this->put(route('category.update', $categories->id), ['name' => 'Sekolah']);
        $this->assertDatabaseHas('categories', ['name' => 'Sekolah']);
    }

    public function test_category_can_be_deleted()
    {
        $this->user();
        $this->delete('/category/delete/1');
        $this->assertDatabaseEmpty('categories');
    }
}
