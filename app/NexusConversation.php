<?php

namespace App;

use App\NexusUser;
use App\NexusMessage;
use Illuminate\Database\Eloquent\Model;

class NexusConversation extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'conversations';

    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(NexusUser::class);
    }

    public function messages()
    {
        return $this->hasMany(NexusMessage::class, 'conversation_id');
    }
}
