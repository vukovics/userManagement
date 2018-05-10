<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $group_name
 * @property UserGroup[] $userGroups
 */
class Groups extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['group_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userGroups()
    {
        return $this->hasMany('App\UserGroup');
    }
}
