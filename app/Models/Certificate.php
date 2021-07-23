<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function driver()
    {
        return $this->belongsTo(Contact::class, 'driver_id');
    }

    public function washingProcedure()
    {
        return $this->belongsTo(WashingProcedure::class, 'washing_procedure_id');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->with('contractor');
            $query->with('driver');
            $query->where(function ($query) use ($search) {
                $query->where('series', 'like', '%'.$search.'%')
                ->orWhereHas('Contractor', function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhere('nip', 'like', '%'.$search.'%');
                })
                ->orWhereHas('Driver', function($q) use ($search) {
                    $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('WashingProcedure', function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
                });;
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
