<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'thread_id',
        'user_id',
        'body',
        'is_solution',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_solution' => 'boolean',
        ];
    }

    /**
     * Get the thread that owns the post.
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get the user that created the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark this post as the solution.
     */
    public function markAsSolution(): void
    {
        // Unmark any other solutions in this thread
        $this->thread->posts()->where('id', '!=', $this->id)->update(['is_solution' => false]);
        
        // Mark this post as solution
        $this->update(['is_solution' => true]);
    }
}
