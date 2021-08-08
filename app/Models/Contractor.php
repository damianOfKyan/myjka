<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractor extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['label'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the Contractor's label.
     *
     * @param  string  $value
     * @return string
     */
    public function getLabelAttribute()
    {
        return implode(' - ', [
            $this->code,
            $this->name,
            $this->nip
        ]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhere('nip', 'like', '%'.$search.'%');
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
