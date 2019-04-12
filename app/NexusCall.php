<?php

namespace App;

use App\NexusUser;
use Illuminate\Database\Eloquent\Model;

class NexusCall extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'calls';

    public function user()
    {
        return $this->belongsTo(NexusUser::class);
    }
}
