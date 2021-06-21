<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactsTest extends TestCase
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

        $contractor = $this->contractors()->create(['name' => 'Example Contractors Inc.']);

        $this->contacts()->createMany([
            [
                'first_name' => 'Martin',
                'last_name' => 'Abbott',
                'email' => 'martin.abbott@example.com',
                'phone' => '555-111-2222',
                'address' => '330 Glenda Shore',
                'city' => 'Murphyland',
                'country' => 'US',
                'postal_code' => '57851',
            ], [
                'first_name' => 'Lynn',
                'last_name' => 'Kub',
                'email' => 'lynn.kub@example.com',
                'phone' => '555-333-4444',
                'address' => '199 Connelly Turnpike',
                'city' => 'Woodstock',
                'country' => 'US',
                'postal_code' => '11623',
            ],
        ]);
    }

    public function test_can_view_contacts()
    {
        $this->actingAs($this->user)
            ->get('/contacts')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contacts/Index')
                ->has('contacts.data', 2)
                ->has('contacts.data.0', fn ($assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Martin Abbott')
                    ->where('phone', '555-111-2222')
                    ->where('city', 'Murphyland')
                    ->where('deleted_at', null)
                    ->has('contractor', fn ($assert) => $assert
                        ->where('name', 'Example Contractors Inc.')
                    )
                )
                ->has('contacts.data.1', fn ($assert) => $assert
                    ->where('id', 2)
                    ->where('name', 'Lynn Kub')
                    ->where('phone', '555-333-4444')
                    ->where('city', 'Woodstock')
                    ->where('deleted_at', null)
                    ->has('contractor', fn ($assert) => $assert
                        ->where('name', 'Example Contractors Inc.')
                    )
                )
            );
    }

    public function test_can_search_for_contacts()
    {
        $this->actingAs($this->user)
            ->get('/contacts?search=Martin')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contacts/Index')
                ->where('filters.search', 'Martin')
                ->has('contacts.data', 1)
                ->has('contacts.data.0', fn ($assert) => $assert
                    ->where('id', 1)
                    ->where('name', 'Martin Abbott')
                    ->where('phone', '555-111-2222')
                    ->where('city', 'Murphyland')
                    ->where('deleted_at', null)
                    ->has('contractor', fn ($assert) => $assert
                        ->where('name', 'Example Contractors Inc.')
                    )
                )
            );
    }

    public function test_cannot_view_deleted_contacts()
    {
        $this->contacts()->firstWhere('first_name', 'Martin')->delete();

        $this->actingAs($this->user)
            ->get('/contacts')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contacts/Index')
                ->has('contacts.data', 1)
                ->where('contacts.data.0.name', 'Lynn Kub')
            );
    }

    public function test_can_filter_to_view_deleted_contacts()
    {
        $this->contacts()->firstWhere('first_name', 'Martin')->delete();

        $this->actingAs($this->user)
            ->get('/contacts?trashed=with')
            ->assertInertia(fn ($assert) => $assert
                ->component('Contacts/Index')
                ->has('contacts.data', 2)
                ->where('contacts.data.0.name', 'Martin Abbott')
                ->where('contacts.data.1.name', 'Lynn Kub')
            );
    }
}
