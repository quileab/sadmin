<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'pid',
        'lastname',
        'firstname',
        'phone',
        'enabled',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url'
    ];

    // *** Guardo como ejemplo ***
    // public function student(){
    //     return $this->hasOne('App\Models\Student')
    //         ->withDefault([
    //            "lastname"=>"",
    //            "name"=>"",
    //            "phone"=>"",
    //            "enabled"=>1,
    //            "career_id"=>1
    //         ]);
    // }

    // users may have multiple careers
    public function careers(): BelongsToMany {
        return $this->belongsToMany(Career::class);
    }

    public function book() {
        return $this->hasMany('App\Models\Books');
    }

    public function subjects() {
        // return records from 'subjects' that have a record in 'grades' table with date_id=2000-01-01 and user_id=this->id and subject_id=subject_id
        return
            \App\Models\Subject::select('subjects.*')
            ->join('grades', function ($join) {
                $join->on('subjects.id', '=', 'grades.subject_id')
                    ->where('grades.date_id', '=', '2000-01-01')
                    ->where('grades.user_id', '=', $this->id);
            });
        
        // return $this->hasMany(Grade::class)
        // ->where('date_id','2000-01-01');
    }

    public function grades() {
        return $this->belongsToMany(Grade::class);
    }

    public function payments() {
        return $this->hasMany('App\Models\PaymentRecord');
    }

    public function getCountByRole() {
        // return array with key=role and value=count
        $roles = \Spatie\Permission\Models\Role::select(['name'])->get(); //all();
        $users = \App\Models\User::select('id')->with('roles')->get();
        $counts = [];
        foreach ($roles as $role) {
            $counts[$role->name] = $users->filter(function ($user) use ($role) {
                return $user->hasRole($role->name);
            })->count();
        }
        $counts['roleless'] = User::whereDoesntHave('roles')->count();

        return $counts;
    }

    // return true if the user has grade approved on date=2000-01-01
    public function enrolled($subject_id): bool{
        return \App\Models\Grade::where('subject_id', $subject_id)->
            //where('user_id', $user_id)->
            where('date_id','2000-01-01')->count() ? true : false;
    }

    public function enroll(int $subject, bool $enroll = true) {
        if ($enroll){
            $result=\App\Models\Grade::create([
                'user_id'=>$this->id,
                'subject_id'=>$subject,
                'date_id'=>'2000-01-01'])
                ->save();
            return $result;
        } else {
            $result=\App\Models\Grade::where('user_id',$this->id)
                ->where('subject_id',$subject)
                ->where('date_id','2000-01-01')
                ->delete();
            return $result;
        }

    }
}