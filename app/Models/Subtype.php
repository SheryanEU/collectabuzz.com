<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Subtype as SubtypeDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtype extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'subtype';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function toDto(): SubtypeDto
    {
        return SubtypeDto::fromModel($this);
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_subtype');
    }
}
