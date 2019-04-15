<?php

namespace App;

use App\NexusConversation;
use Illuminate\Database\Eloquent\Model;
use App\Nova\NexusUser;

class NexusMessage extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'messages';

    protected $primaryKey = 'id';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function conversation()
    {
        return $this->belongsTo(NexusConversation::class);
    }
}
