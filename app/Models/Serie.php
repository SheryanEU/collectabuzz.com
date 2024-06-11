<?php

namespace App\Models;

use App\Dto\Serie as SerieDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serie extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'serie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serie_id',
        'name',
        'slug',
        'description',
        'hexadecimalcolor',
        'logo_src',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the sets for the series.
     */
    public function sets(): HasMany
    {
        return $this->hasMany(Set::class, 'serie_id', 'id')->orderBy('release_date', 'desc');
    }

    public function toDto(): SerieDto
    {
        return SerieDto::fromModel($this);
    }
}
