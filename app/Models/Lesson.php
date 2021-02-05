<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    /**
     * Get the subject taught in the lesson.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the room the lesson took place in.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * The students that attended the lesson.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'attendances', 'lesson_id', 'student_id')
            ->as('attendance')
            ->withTimestamps('time_in', 'time_out');
    }
}
