<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractorsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        $this->contractors()->createMany([
            [
                'name' => 'Apple',
                'email' => 'info@apple.com',
                'phone' => '647-943-4400',
                'address' => '1600-120 Bremner Blvd',
                'city' => 'Toronto',
                'country' => 'CA',
                'postal_code' => 'M5J 0A8',
            ], [
                'name' => 'Microsoft',
                'email' => 'info@microsoft.com',
                'phone' => '877-568-2495',
                'address' => 'One Microsoft Way',
                'city' => 'Redmond',
                'country' => 'US',
                'postal_code' => '98052',
            ],
        ]);
    }

    public function test_can_view_contractors()
    {
        $this->actingAs($this->user)
            ->get('/contractors')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contractors/Index')
                ->has('contractors.data', 2)
                ->has('contractors.data.0', fn ($assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Apple')
                    ->where('phone', '647-943-4400')
                    ->where('city', 'Toronto')
                    ->where('deleted_at', null)
                )
                ->has('contractors.data.1', fn ($assert) => $assert
                    ->where('id', 2)
                    ->where('name', 'Microsoft')
                    ->where('phone', '877-568-2495')
                    ->where('city', 'Redmond')
                    ->where('deleted_at', null)
                )
            );
    }

    public function test_can_search_for_contractors()
    {
        $this->actingAs($this->user)
            ->get('/contractors?search=Apple')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contractors/Index')
                ->where('filters.search', 'Apple')
                ->has('contractors.data', 1)
                ->has('contractors.data.0', fn ($assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Apple')
                    ->where('phone', '647-943-4400')
                    ->where('city', 'Toronto')
                    ->where('deleted_at', null)
                )
            );
    }

    public function test_cannot_view_deleted_contractors()
    {
        $this->contractors()->firstWhere('name', 'Microsoft')->delete();

        $this->actingAs($this->user)
            ->get('/contractors')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contractors/Index')
                ->has('contractors.data', 1)
                ->where('contractors.data.0.name', 'Apple')
            );
    }

    public function test_can_filter_to_view_deleted_contractors()
    {
        $this->contractors()->firstWhere('name', 'Microsoft')->delete();

        $this->actingAs($this->user)
            ->get('/contractors?trashed=with')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contractors/Index')
                ->has('contractors.data', 2)
                ->where('contractors.data.0.name', 'Apple')
                ->where('contractors.data.1.name', 'Microsoft')
            );
    }
}
