<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pokemon extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'name',
        'generation',
        'status',
        'species',
        'primary_type',
        'secondary_type',
        'height',
        'weight',
        'primary_ability',
        'secondary_ability',
        'hidden_ability',
        'health_points',
        'attack',
        'defence',
        'sp_attack',
        'sp_defense',
    ];
}
