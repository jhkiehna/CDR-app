<?php

namespace App;

use App\NexusCall;
use Illuminate\Database\Eloquent\Model;

class NexusUser extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'users';

    public function calls()
    {
        return $this->hasMany(NexusCall::class, 'user_id');
    }
}
