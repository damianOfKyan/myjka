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
        return $this->belongsTo(Contractor::class);
    }

    public function driver()
    {
        return $this->belongsTo(Contact::class);
    }

    public function washingProcedure()
    {
        return $this->belongsToMany(WashingProcedure::class);
    }

    public function washingRange()
    {
        return $this->belongsToMany(WashingRange::class);
    }

    public function detergent()
    {
        return $this->belongsToMany(Detergent::class);
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
                ->orWhere('date_of_arrival', 'like', '%'.$search.'%')
                ->orWhere('date_of_departure', 'like', '%'.$search.'%')
                ->orWhere('tractor', 'like', '%'.$search.'%')
                ->orWhere('bowser', 'like', '%'.$search.'%')
                ->orWhere('container', 'like', '%'.$search.'%')
                ->orWhere('last_product', 'like', '%'.$search.'%')
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
                    $q->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('WashingRange', function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('Detergent', function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                });
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
