<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // protected $with = ['users'];
    protected $appends = ['date_enrolled'];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function getDateEnrolledAttribute()
    {
        $registeredUser = $this->users()->wherePivot('user_id', auth()->getUser()->id)->first(['course_user.created_at']);
        return $registeredUser ? $registeredUser->created_at->format('Y-m-d') : null;
        // return auth()->getUser();
    }
}
