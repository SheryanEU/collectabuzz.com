<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    protected $table = 'set';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'set_id',
        'card_id',
        'name',
        'variant',
        'supertype',
        'subtypes',
        'hp',
        'types',
        'attacks',
        'weaknesses',
        'rarity',
        'artist',
        'image',
    ];

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'set_id', 'id');
    }

    public function toDto(): CardDto
    {
        return CardDto::fromModel($this);
    }
}
