<?php

namespace App;

use App\NexusConversation;
use Illuminate\Database\Eloquent\Model;

class NexusMessage extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'messages';

    protected $primaryKey = 'id';

    protected $hidden = [
        'body'
    ];

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function conversation()
    {
        return $this->belongsTo(NexusConversation::class);
    }

    public function getUser()
    {
        return $this->conversation->user;
    }
}
