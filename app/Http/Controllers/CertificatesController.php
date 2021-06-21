<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Contact;
use App\Models\Contractor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CertificatesController extends Controller
{
    public function index()
    {
        return Inertia::render('Certificates/Index', [
            'filters' => Request::all('search', 'trashed'),
            'certificates' => Certificate::orderBy('series')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($certificate) => [
                    'id' => $certificate->id,
                    'contractor' => $certificate->contractor,
                    'driver' => $certificate->driver,
                    'series' => $certificate->series,
                    'date_of_arrival' => Carbon::parse(
                        $certificate->date_of_arrival
                    )->format('Y-m-d'),
                    'date_of_departure' => Carbon::parse(
                        $certificate->date_of_departure
                    )->format('Y-m-d'),
                    'tractor' => $certificate->tractor,
                    'bowser' => $certificate->bowser,
                    'container' => $certificate->container,
                    'last_product' => $certificate->last_product,
                    'washing_range' => $certificate->washing_range,
                    'washing_procedure' => $certificate->washing_procedure,
                    'detergents' => $certificate->detergents,
                    'chamber' => $certificate->chamber,
                    'partitions' => $certificate->partitions,
                    'seals' => $certificate->seals,
                    'deleted_at' => $certificate->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Certificates/Create', [
            'certificate' => [
                'drivers' => Contact::orderBy('first_name')->get()->map->only(
                    'id',
                    'first_name',
                    'last_name'
                ),
                'contractors' => Contractor::orderBy('name')->get()->map->only(
                    'id',
                    'name',
                    'code'
                )
            ]
        ]);
    }

    public function store()
    {
        Certificate::create(
            Request::validate([
                'series' => ['nullable', 'max: 10'],
                'date_of_arrival' => ['required', 'max: 100'],
                'date_of_departure' => ['required', 'max: 100'],
                'tractor' => ['nullable', 'max: 20'],
                'bowser' => ['nullable', 'max: 20'],
                'container' => ['nullable', 'max: 20'],
                'last_product' => ['nullable', 'max: 100'],
                'washing_range' => ['nullable', 'max: 1'],
                'washing_procedure' => ['nullable', 'max: 1'],
                'detergents' => ['nullable', 'max: 1'],
                'chamber' => ['nullable', 'max: 1'],
                'partitions' => ['nullable', 'max: 1'],
                'seals' => ['nullable', 'max: 200'],
                'driver_id' => ['required', 'exists:contacts,id'],
                'contractor_id' => ['required', 'exists:contractors,id'],
            ])
        );

        return Redirect::route('certificates')->with('success', 'Certificate created.');
    }

    public function edit(Certificate $certificate)
    {
        $contractor = [
            $certificate->contractor()->get()->map->only(
                'id',
                'nip',
                'name',
                'code',
                'contact_id'
            )->first()
            +
            $certificate->contractor->contact()->get()->map->only(
                'email',
                'phone'
            )->first()
        ];
        return Inertia::render('Certificates/Edit', [
            'certificate' => [
                'id' => $certificate->id,
                'series' => $certificate->series,
                'date_of_arrival' => Carbon::parse(
                    $certificate->date_of_arrival
                )->format('Y-m-d'),
                'date_of_departure' => Carbon::parse(
                    $certificate->date_of_departure
                )->format('Y-m-d'),
                'tractor' => $certificate->tractor,
                'bowser' => $certificate->bowser,
                'container' => $certificate->container,
                'last_product' => $certificate->last_product,
                'washing_range' => $certificate->washing_range,
                'washing_procedure' => $certificate->washing_procedure,
                'detergents' => $certificate->detergents,
                'chamber' => $certificate->chamber,
                'partitions' => $certificate->partitions,
                'seals' => $certificate->seals,
                'deleted_at' => $certificate->deleted_at,
                'contacts' => Contact::orderBy('first_name')->get(),
                'contractors' => Contractor::orderBy('code')->get()->map->only('id', 'code', 'name'),
                'driver_id' => $certificate->driver_id,
                'contractor_id' => $certificate->contractor_id,
                'driver' => $certificate->driver()->get()->map->only(
                    'id',
                    'first_name',
                    'last_name',
                    'phone',
                    'email'
                ),
                'contractor' => $contractor
            ],
        ]);
    }

    public function update(Certificate $certificate)
    {
        $certificate->update(
            Request::validate([
                'contractor_id' => ['required', 'max: 100'],
                'series' => ['nullable', 'max: 10'],
                'date_of_arrival' => ['nullable', 'max: 100'],
                'date_of_departure' => ['nullable', 'max: 100'],
                'tractor' => ['nullable', 'max: 20'],
                'bowser' => ['nullable', 'max: 20'],
                'container' => ['nullable', 'max: 20'],
                'last_product' => ['nullable', 'max: 100'],
                'washing_range' => ['nullable', 'max: 1'],
                'washing_procedure' => ['nullable', 'max: 1'],
                'detergents' => ['nullable', 'max: 1'],
                'chamber' => ['nullable', 'max: 1'],
                'partitions' => ['nullable', 'max: 1'],
                'seals' => ['nullable', 'max: 200'],
            ])
        );

        return Redirect::back()->with('success', 'Certificate updated.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return Redirect::back()->with('success', 'Certificate deleted.');
    }

    public function restore(Certificate $certificate)
    {
        $certificate->restore();

        return Redirect::back()->with('success', 'Certificate restored.');
    }
}
