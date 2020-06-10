<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PasswordStorage extends Model
{
    protected $table = 'password_storage';

    protected $fillable = [
        'platform',
        'platform_url',
        'username',
        'password',
        'user_id'
    ];

    /**
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Crypt::encryptString($password);
    }

    /**
     * @return string
     */
    public function getPasswordAttribute($password)
    {
        return Crypt::decryptString($password);
    }
}
