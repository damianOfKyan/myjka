<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ContractorsController extends Controller
{
    public function index()
    {
        return Inertia::render('Contractors/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contractors' => Contractor::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($contractor) => [
                    'id' => $contractor->id,
                    'code' => $contractor->code,
                    'name' => $contractor->name,
                    'nip' => $contractor->nip,
                    'deleted_at' => $contractor->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        $contacts = Contact::get()->map->only(
            'id',
            'first_name',
            'last_name',
            'label', // accessor
            'name', // accessor
            'phone',
            'address',
            'postal_code',
            'city',
            'country'
        );

        return Inertia::render('Contractors/Create', [
            'contractor' => [
                'contacts' => $contacts,
            ]
        ]);
    }

    public function store()
    {
        $contact = collect(Request::input('contact'));

        $validated = Request::validate([
            'code' => ['required', 'max:50'],
            'name' => ['required', 'max:100'],
            'nip' => ['required', 'max:20'],
            'contact.id' => ['required', 'exists:contacts,id'],
        ]);

        $newArr = $validated;
        $newArr['contact_id'] = $validated['contact']['id'];
        unset($newArr['contact']);

        Contractor::create($newArr);

        return Redirect::route('contractors')->with('success', __('messages.Created'));
    }

    public function edit(Contractor $contractor)
    {
        $contacts = Contact::get()->map->only(
            'id',
            'first_name',
            'last_name',
            'label', // accessor
            'name', // accessor
            'phone',
            'address',
            'postal_code',
            'city',
            'country'
        );

        return Inertia::render('Contractors/Edit', [
            'contractor' => [
                'id' => $contractor->id,
                'code' => $contractor->code,
                'name' => $contractor->name,
                'nip' => $contractor->nip,
                'deleted_at' => $contractor->deleted_at,
                'contact_id' => $contractor->contact_id,
                'contacts' => $contacts,
                'contact' => $contractor->contact()->get()->map->only(
                    'id',
                    'first_name',
                    'last_name',
                    'label', // accessor
                    'name', // accessor
                    'phone',
                    'address',
                    'postal_code',
                    'city',
                    'country'
                ),
            ],
        ]);
    }

    public function update(Contractor $contractor)
    {
        $contact = collect(Request::input('contact'));

        $validated = Request::validate([
            'code' => ['required', 'max:50'],
            'name' => ['nullable', 'max:100'],
            'nip' => ['required', 'max:20'],
            'contact.id' => ['required', 'exists:contacts,id'],
        ]);

        $newArr = $validated;
        $newArr['contact_id'] = $validated['contact']['id'];
        unset($newArr['contact']);
        $contractor->update($newArr);

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(Contractor $contractor)
    {
        $contractor->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(Contractor $contractor)
    {
        $contractor->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }
}
