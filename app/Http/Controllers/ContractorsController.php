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
        return Inertia::render('Contractors/Create', [
            'contractor' => [
                'contacts' => Contact::all(),
            ]
        ]);
    }

    public function store()
    {
        Contractor::create(
            Request::validate([
                'code' => ['required', 'max:50'],
                'name' => ['required', 'max:100'],
                'nip' => ['required', 'max:20'],
                'contact_id' => [
                    'required',
                    'exists:contacts,id'
                ],
            ])
        );

        return Redirect::route('contractors')->with('success', __('messages.Created'));
    }

    public function edit(Contractor $contractor)
    {
        return Inertia::render('Contractors/Edit', [
            'contractor' => [
                'id' => $contractor->id,
                'code' => $contractor->code,
                'name' => $contractor->name,
                'nip' => $contractor->nip,
                'deleted_at' => $contractor->deleted_at,
                'contact_id' => $contractor->contact_id,
                'contacts' => Contact::all(),
                'contact' => $contractor->contact()->get()->map->only(
                    'id',
                    'name',
                    'first_name',
                    'last_name',
                    'city',
                    'phone'
                ),
            ],
        ]);
    }

    public function update(Contractor $contractor)
    {
        $contractor->update(
            Request::validate([
                'code' => ['required', 'max:50'],
                'name' => ['nullable', 'max:100'],
                'nip' => ['required', 'max:20'],
                'contact_id' => [
                    'nullable',
                    'exists:contacts,id'
                ],
            ]),
        );

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
