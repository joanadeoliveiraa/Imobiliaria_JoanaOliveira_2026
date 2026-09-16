<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Venda::class);
    }

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'telefone',
        'morada',
        'nif',
    ];
}
