<?php

namespace App\Http\Controllers;

use App\Models\Detergent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DetergentController extends Controller
{
    public function index()
    {
        return Inertia::render('Detergents/Index', [
            'filters' => Request::all('search', 'trashed'),
            'detergents' => Detergent::orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
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
        return Inertia::render('Detergents/Create');
    }

    public function store()
    {
        Detergent::create(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::route('detergents')->with('success', __('messages.Created'));
    }

    public function edit(Detergent $detergent)
    {
        return Inertia::render('Detergents/Edit', [
            'detergent' => [
                'id' => $detergent->id,
                'name' => $detergent->name,
                'description' => $detergent->description,
                'deleted_at' => $detergent->deleted_at,
            ]
        ]);
    }

    public function update(Detergent $detergent)
    {
        $detergent->update(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(Detergent $detergent)
    {
        $detergent->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(Detergent $detergent)
    {
        $detergent->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }
}
