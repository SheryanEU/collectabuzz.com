<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Attack as AttackDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attack extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'attack';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'converted_energy_cost',
        'damage',
        'description',
    ];

    public function toDto(): AttackDto
    {
        return AttackDto::fromModel($this);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'attack_type')->withPivot('cost');
    }
}
