<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    protected $fillable = [
        'type',
        'url',
        'width',
        'height'
    ];

    protected $primaryKey = ['channel_id', 'type'];
    public $incrementing = false;
    protected $keyType = ['string', 'date'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
