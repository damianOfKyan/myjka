<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Contact;
use App\Models\Contractor;
use App\Models\WashingProcedure;
use App\Models\WashingRange;
use App\Models\Detergent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Carbon\Carbon;

class CertificatesController extends Controller
{
    public function index()
    {
        return Inertia::render('Certificates/Index', [
            'filters' => Request::all('search', 'trashed'),
            'certificates' => Certificate::orderBy('updated_at', 'desc')
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
                    'washing_procedure' => $certificate->washingProcedure()->get()->map->only(
                        'id',
                        'name',
                    )->pluck('name')->implode(', '),
                    'washing_range' => $certificate->washingRange()->get()->map->only(
                        'id',
                        'name',
                    )->pluck('name')->implode(', '),
                    'detergent' => $certificate->detergent()->get()->map->only(
                        'id',
                        'name',
                    )->pluck('name')->implode(', '),
                    'chamber' => $certificate->chamber,
                    'partitions' => $certificate->partitions,
                    'seals' => $certificate->seals,
                    'deleted_at' => $certificate->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        $drivers = Contact::where('first_name', '<>', 'NULL')->orWhere('last_name', '<>', 'NULL')->get()->map->only(
            'id',
            'first_name',
            'last_name',
            'label', // accessor
            'name', // accessor
        );

        return Inertia::render('Certificates/Create', [
            'certificate' => [
                'drivers' => $drivers,
                'contractors' => Contractor::orderBy('name')->get()->map->only(
                    'id',
                    'name',
                    'code',
                    'label', // accessor
                ),
                'washing_procedures' => WashingProcedure::orderBy('name')->get()->map->only('id', 'name'),
                'washing_ranges' => WashingRange::orderBy('name')->get()->map->only('id', 'name'),
                'detergents' => Detergent::orderBy('name')->get()->map->only('id', 'name'),
            ]
        ]);
    }

    public function store()
    {
        $validated = Request::validate([
            'series' => ['required', 'max: 10'],
            'date_of_arrival' => ['required', 'max: 100'],
            'date_of_departure' => ['required', 'max: 100'],
            'tractor' => ['nullable', 'max: 20'],
            'bowser' => ['nullable', 'max: 20'],
            'container' => ['nullable', 'max: 20'],
            'last_product' => ['nullable', 'max: 100'],
            'chamber' => ['nullable', 'max: 255'],
            'partitions' => ['nullable', 'max: 255'],
            'seals' => ['nullable', 'max: 255'],
            'driver.id' => ['required', 'exists:contacts,id'],
            'contractor.id' => ['required', 'exists:contractors,id'],
            'washing_procedure.id' => ['nullable', 'exists:washing_procedure,id'],
            'detergent.id' => ['nullable', 'exists:detergent,id'],
            'washing_range.id' => ['nullable', 'exists:washing_range,id'],
        ]);

        $newArr = $validated;
        $newArr['driver_id'] = $validated['driver']['id'];
        $newArr['contractor_id'] = $validated['contractor']['id'];
        unset($newArr['driver']);
        unset($newArr['contractor']);

        $certificate = Certificate::create($newArr);

        if ($certificate) {
            $washingProcedure = collect(Request::input('washing_procedure'));
            $certificate->washingProcedure()->sync($washingProcedure->pluck('id'));

            $detergent = collect(Request::input('detergent'));
            $certificate->detergent()->sync($detergent->pluck('id'));

            $washingRange = collect(Request::input('washing_range'));
            $certificate->washingRange()->sync($washingRange->pluck('id'));
        }

        return Redirect::route('certificates')->with('success', __('messages.Created'));
    }

    public function edit(Certificate $certificate)
    {
        $contractor = [
            $certificate->contractor()->get()->map->only(
                'id',
                'nip',
                'label', // accessor
                'name',
                'code',
                'contact_id'
            )->first()
            +
            $certificate->contractor->contact()->get()->map->only(
                'email',
                'phone',
                'label'
            )->first()
        ];

        $drivers = Contact::where('first_name', '<>', 'NULL')->orWhere('last_name', '<>', 'NULL')->get()->map->only(
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

        return Inertia::render('Certificates/Edit', [
            'certificate' => [
                'id' => $certificate->id,
                'series' => $certificate->series,
                'date_of_arrival' => Carbon::parse(
                    $certificate->date_of_arrival
                )->format('Y-m-d\TH:i'),
                'date_of_departure' => Carbon::parse(
                    $certificate->date_of_departure
                )->format('Y-m-d\TH:i'),
                'tractor' => $certificate->tractor,
                'bowser' => $certificate->bowser,
                'container' => $certificate->container,
                'last_product' => $certificate->last_product,
                'chamber' => $certificate->chamber,
                'partitions' => $certificate->partitions,
                'seals' => $certificate->seals,
                'deleted_at' => $certificate->deleted_at,
                'contacts' => Contact::orderBy('first_name')->get(),
                'contractors' => Contractor::orderBy('code')->get()->map->only('id', 'code', 'name', 'label'),
                'washing_procedures' => WashingProcedure::orderBy('name')->get()->map->only('id', 'name'),
                'washing_procedure' => $certificate->washingProcedure()->get()->map->only(
                    'id',
                    'name',
                    'description',
                ),
                'washing_ranges' => WashingRange::orderBy('name')->get()->map->only('id', 'name'),
                'washing_range' => $certificate->washingRange()->get()->map->only(
                    'id',
                    'name',
                    'description',
                ),
                'detergents' => Detergent::orderBy('name')->get()->map->only('id', 'name'),
                'detergent' => $certificate->detergent()->get()->map->only(
                    'id',
                    'name',
                    'description',
                ),
                'driver_id' => $certificate->driver_id,
                'contractor_id' => $certificate->contractor_id,
                'driver' => $certificate->driver()->get()->map->only(
                    'id',
                    'first_name',
                    'last_name',
                    'label', // accessor
                    'name', // accessor
                    'phone',
                    'email'
                ),
                'drivers' => $drivers,
                'contractor' => $contractor,
            ],
        ]);
    }

    public function update(Certificate $certificate)
    {
        $validated = Request::validate([
            'series' => ['nullable', 'max: 10'],
            'date_of_arrival' => ['nullable', 'max: 100'],
            'date_of_departure' => ['nullable', 'max: 100'],
            'tractor' => ['nullable', 'max: 20'],
            'bowser' => ['nullable', 'max: 20'],
            'container' => ['nullable', 'max: 20'],
            'last_product' => ['nullable', 'max: 100'],
            'chamber' => ['nullable', 'max: 255'],
            'partitions' => ['nullable', 'max: 255'],
            'seals' => ['nullable', 'max: 255'],
            'driver.id' => ['required', 'exists:contacts,id'],
            'contractor.id' => ['required', 'exists:contractors,id'],
        ]);

        $newArr = $validated;
        $newArr['driver_id'] = $validated['driver']['id'];
        $newArr['contractor_id'] = $validated['contractor']['id'];
        unset($newArr['driver']);
        unset($newArr['contractor']);

        $certificate->update($newArr);

        $washingProcedure = collect(Request::input('washing_procedure'));
        $certificate->washingProcedure()->sync($washingProcedure->pluck('id'));

        $detergent = collect(Request::input('detergent'));
        $certificate->detergent()->sync($detergent->pluck('id'));

        $washingRange = collect(Request::input('washing_range'));
        $certificate->washingRange()->sync($washingRange->pluck('id'));

        return Redirect::back()->with('success', __('messages.Updated'));
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return Redirect::back()->with('success', __('messages.Deleted'));
    }

    public function restore(Certificate $certificate)
    {
        $certificate->restore();

        return Redirect::back()->with('success', __('messages.Restored'));
    }

    public function clone(Certificate $certificate)
    {
        $clone = $certificate->replicateRecord();

        return Redirect::route('certificates.edit', $clone->id)->with('success', __('messages.Created'));
    }

    public function print(Certificate $certificate)
    {
        $contractor = (
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
                'address',
                'city',
                'country',
                'postal_code',
                'phone'
            )->first()
        );

        return Inertia::render('Certificates/Print', [
            'certificate' => [
                'id' => $certificate->id,
                'series' => $certificate->series,
                'date_of_arrival' => Carbon::parse(
                    $certificate->date_of_arrival
                )->format('Y-m-d @ H:i'),
                'date_of_departure' => Carbon::parse(
                    $certificate->date_of_departure
                )->format('Y-m-d @ H:i'),
                'tractor' => $certificate->tractor,
                'bowser' => $certificate->bowser,
                'container' => $certificate->container,
                'last_product' => $certificate->last_product,
                'washing_range_id' => $certificate->washing_range,
                'washing_ranges' => $certificate->washingRange()->get()->map->only(
                    'id',
                    'name',
                    'description'
                ),
                'washing_procedure_id' => $certificate->washing_procedure,
                'washing_procedures' => $certificate->washingProcedure()->get()->map->only(
                    'id',
                    'name',
                    'description'
                ),
                'detergents' => $certificate->detergent()->get()->map->only(
                    'id',
                    'name',
                    'description'
                ),
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
}
