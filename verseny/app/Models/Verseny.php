<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Verseny extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'verseny';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'verseny_nev',
        'verseny_ev',
        'verseny_terulet',
        'verseny_leiras'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    public function rounds(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Fordulok::class);
    }
    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'languages_pairs', 'verseny_id', 'language_id');
    }
}
