<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdatedUser extends Model
{
    public const ID = 'id';
    public const FIRSTNAME = 'firstname';
    public const LASTNAME = 'lastname';
    public const EMAIL = 'email';
    public const API_RESPONSE = 'api_response';
    public const IS_API_POST_SUCCESS = 'is_api_post_success';
    public const RETRY = 'retry';
    public const TIMEZONE = 'timezone';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'email',
        'lastname',
        'timezone',
    ];
}
