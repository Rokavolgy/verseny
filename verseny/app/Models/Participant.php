<?php

namespace App\Models;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    public $timestamps = false;
    public $usesUniqueIds = false;
    protected $table = 'participants';

    protected $fillable = [
        'round_id',
        'user_id',
    ];

    public function round(): BelongsTo
    {
        return $this->belongsTo(Fordulok::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
