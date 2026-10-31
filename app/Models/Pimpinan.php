<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pimpinan extends Model
{
    use HasFactory;

    protected $table = 'pimpinans';

    protected $fillable = [
        'id_user',
        'nama',
        'username',
        'email',
        'no_hp',
        'jabatan',
        'gender',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
