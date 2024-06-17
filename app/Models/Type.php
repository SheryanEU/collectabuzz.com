<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Type as TypeDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'type';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function toDto(): TypeDto
    {
        return TypeDto::fromModel($this);
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_type');
    }

    public function attacks(): BelongsToMany
    {
        return $this->belongsToMany(Attack::class, 'attack_type')->withPivot('cost');
    }

    public function weaknesses(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_weakness')->withPivot('value');
    }
}
