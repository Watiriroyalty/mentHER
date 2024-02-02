<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'gender',
        'experience',
        'bio', 
        'profile_picture_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function potentialMatches()
    {
        // Check if the user is a mentor or mentee
        if ($this->role === 'mentor') {
            // If the user is a mentor, find potential mentees with similar skills
            return User::whereHas('skills', function ($query) {
                $query->whereIn('skills.id', $this->skills->pluck('id'));
            })->where('role', 'mentee')->get();
        } elseif ($this->role === 'mentee') {
            // If the user is a mentee, find potential mentors with similar skills
            return User::whereHas('skills', function ($query) {
                $query->whereIn('skills.id', $this->skills->pluck('id'));
            })->where('role', 'mentor')->get();
        } else {
            // If the user has an unknown role, return an empty collection
            return collect();
        }
    }
    //Relationship Definition

    public function skills()
    {
        // a user can have multiple skill and a skill can belong to multiple users
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function mentorshipRequestsSent()
    {
       
        return $this->hasMany(MentorshipRequest::class, 'mentee_id');
    }

    public function mentorshipRequestsReceived()
    {
        return $this->hasMany(MentorshipRequest::class, 'mentor_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function meetingRequestsSent()
    {
        return $this->hasMany(MeetingRequest::class, 'requester_id');
    }

    public function meetingRequestsReceived()
    {
        return $this->hasMany(MeetingRequest::class, 'recipient_id');
    }
}
