<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NexusUser extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'users';
}
