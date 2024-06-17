<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Card as CardDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'card';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'set_id',
        'card_id',
        'pokemon_id',
        'variant',
        'supertype',
        'hp',
        'rarity',
        'artist',
        'image'
    ];

    public function toDto(): CardDto
    {
        return CardDto::fromModel($this);
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'set_id', 'id');
    }

    public function pokemon(): BelongsTo
    {
        return $this->belongsTo(Pokemon::class);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'card_type');
    }

    public function subtypes(): BelongsToMany
    {
        return $this->belongsToMany(Subtype::class, 'card_subtype');
    }

    public function attacks(): BelongsToMany
    {
        return $this->belongsToMany(Attack::class, 'card_attack')->withPivot('cost');
    }

    public function weaknesses(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'card_weakness')->withPivot('value');
    }

    public function scopeWithSetAndSerie($query)
    {
        return $query->with(['set', 'set.serie']);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['set', 'set.serie', 'types', 'subtypes', 'attacks', 'weaknesses']);
    }

    public function scopeWithDetails($query)
    {
        return $query->with(['types', 'subtypes', 'attacks', 'weaknesses']);
    }

    public function scopeWithType($query)
    {
        return $query->with('types');
    }

    public function scopeWithSubtype($query)
    {
        return $query->with('subtypes');
    }
}
