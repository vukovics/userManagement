<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable implements JWTSubject
{
    /**
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'created_at', 'updated_at'];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userGroups()
    {
        return $this->hasMany('App\UserGroup');
    }


    public function createNewUser($data)
    {

        $rules = [
            'email' => 'required',
            'password' => 'required',

        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            return ['errors' => $validator->messages()->toJson()];
        }

        try {
            $this->email = $data['email'];
            $this->password = bcrypt($data['password']);

            $this->save();

            return true;

        } catch (QueryException $e) {
            return $e->getMessage();
        }

    }


}



