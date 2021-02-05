<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Get the lessons for the subjects.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(lesson::class);
    }

    /**
     * The techer that teaches the subject.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * The students that are registered in the subject.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'registrations', 'subject_id', 'lesson_id')
            ->as('registration');
    }
}
