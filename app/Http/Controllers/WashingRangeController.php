<?php

namespace App\Http\Controllers;

use App\Models\WashingRange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class WashingRangeController extends Controller
{
    public function index()
    {
        return Inertia::render('WashingRanges/Index', [
            'filters' => Request::all('search', 'trashed'),
            'washingRanges' => WashingRange::orderByName()
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
        return Inertia::render('WashingRanges/Create');
    }

    public function store()
    {
        WashingRange::create(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::route('washing-ranges')->with('success', __('messages.Created'));
    }

    public function edit(WashingRange $washingRange)
    {
        return Inertia::render('WashingRanges/Edit', [
            'washingRange' => [
                'id' => $washingRange->id,
                'name' => $washingRange->name,
                'description' => $washingRange->description,
                'deleted_at' => $washingRange->deleted_at,
            ]
        ]);
    }

    public function update(WashingRange $washingRange)
    {
        $washingRange->update(
            Request::validate([
                'name' => ['required', 'max:255'],
                'description' => ['nullable'],
            ])
        );

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(WashingRange $washingRange)
    {
        $washingRange->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(WashingRange $washingRange)
    {
        $washingRange->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }
}
