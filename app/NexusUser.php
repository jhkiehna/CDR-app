<?php

namespace App;

use App\NexusCall;
use App\NexusMessage;
use App\NexusConversation;
use Illuminate\Database\Eloquent\Model;

class NexusUser extends Model
{
    protected $connection = 'pgsql';

    protected $table = 'users';

    public function calls()
    {
        return $this->hasMany(NexusCall::class, 'user_id');
    }

    public function conversations()
    {
        return $this->hasMany(NexusConversation::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasManyThrough(NexusMessage::class, NexusConversation::class, 'user_id', 'conversation_id');
    }
}
