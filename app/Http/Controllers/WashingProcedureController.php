<?php

namespace App\Http\Controllers;

use App\Models\WashingProcedure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class WashingProcedureController extends Controller
{
    public function index()
    {
        return Inertia::render('WashingProcedures/Index', [
            'filters' => Request::all('search', 'trashed'),
            'washingProcedures' => WashingProcedure::orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(30)
                ->withQueryString()
                ->through(fn ($wp) => [
                    'id' => $wp->id,
                    'name' => $wp->name,
                    'description' => $wp->description,
                    'deleted_at' => $wp->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('WashingProcedures/Create');
    }

    public function store()
    {
        WashingProcedure::create(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::route('washing-procedures')->with('success', __('messages.Created'));
    }

    public function edit(WashingProcedure $washingProcedure)
    {
        return Inertia::render('WashingProcedures/Edit', [
            'washingProcedure' => [
                'id' => $washingProcedure->id,
                'name' => $washingProcedure->name,
                'description' => $washingProcedure->description,
                'deleted_at' => $washingProcedure->deleted_at,
            ]
        ]);
    }

    public function update(WashingProcedure $washingProcedure)
    {
        $washingProcedure->update(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(WashingProcedure $washingProcedure)
    {
        $washingProcedure->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(WashingProcedure $washingProcedure)
    {
        $washingProcedure->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }
}
