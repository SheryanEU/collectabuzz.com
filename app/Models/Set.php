<?php

namespace App\Models;

use App\Dto\Set as SetDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'set';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serie_id',
        'set_id',
        'name',
        'slug',
        'set_code',
        'set_number',
        'set_total',
        'set_master_total',
        'logo_src',
        'symbol_src',
        'release_date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the serie that owns the set.
     */
    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class, 'serie_id', 'id');
    }

    public function toDto(): SetDto
    {
        return SetDto::fromModel($this);
    }
}
