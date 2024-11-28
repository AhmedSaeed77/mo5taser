<?php

namespace App\Models;

use App\Models\Course;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable,HasRoles;

    use  Notifiable;
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password' ,'type' ,'image','phone' , 'subject' , 'role_id' ,'code','active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class , 'role_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_teachers','teacher_id','course_id')->distinct();
    }

}

