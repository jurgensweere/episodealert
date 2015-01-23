<?php namespace EA\models;

use Eloquent;
use EA\models\Seen;
use Auth;

class Following extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'following';

    public function user()
    {
        return $this->belongsTo('EA\models\User');
    }

    public function series()
    {
        return $this->belongsTo('EA\models\Series');
    }
}
