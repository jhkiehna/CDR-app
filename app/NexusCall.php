<?php

namespace App;

use App\NexusUser;
use Illuminate\Database\Eloquent\Model;

class NexusCall extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'calls';

    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(NexusUser::class);
    }
}
