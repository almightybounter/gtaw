<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    // Attribute casting
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Note belongs to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Search scope for title/content
    public function scopeSearch($query, string $search = null)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
