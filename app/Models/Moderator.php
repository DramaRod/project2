<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moderator extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
