<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ContactsController extends Controller
{
    public function index()
    {
        return Inertia::render('Contacts/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contacts' => Contact::orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($contact) => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'city' => $contact->city,
                    'email' => $contact->email,
                    'deleted_at' => $contact->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create');
    }

    public function store()
    {
        Contact::create(
            Request::validate([
                'first_name' => ['nullable', 'max:50'],
                'last_name' => ['nullable', 'max:50'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('contacts')->with('success', __('messages.Created'));
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,
            ]
        ]);
    }

    public function update(Contact $contact)
    {
        $contact->update(
            Request::validate([
                'first_name' => ['nullable', 'max:50'],
                'last_name' => ['nullable', 'max:50'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(Contact $contact)
    {
        $contact->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }
}
