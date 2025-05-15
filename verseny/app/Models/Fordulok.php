<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fordulok extends Model
{
    use HasFactory;

    protected $table = 'rounds';

    protected $fillable = [
        'verseny_id',
        'kor_datum',
    ];

    public function verseny(): BelongsTo
    {
        return $this->belongsTo(Verseny::class);
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participants', 'round_id', 'user_id');
    }

}
