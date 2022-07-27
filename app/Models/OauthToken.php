<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    use HasFactory;

    protected $quarded = [];

    protected $fillable = [
        'user_id', 'realm_id', 'access_token', 'access_token_expires_at', 'refresh_token', 'refresh_token_expires_at'
    ];

    public function hasExpired()
    {
        return now()->gte($this->updated_at->addSeconds($this->access_token_expires_at));
    }
}
