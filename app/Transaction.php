<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    protected $fillable = [
        'date',
        'view_count',
        'view_count_daily',
        'subscriber_count',
        'subscriber_count_daily'
    ];


    protected $primaryKey = ['channel_id', 'date'];
    public $incrementing = false;
    protected $keyType = ['string', 'date'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function($transaction){
            $yesterday = Transaction::where('channel_id', $transaction->channel_id)->where('date', '<>', $transaction->date)->orderBy('date', 'desc')->first();
            if(is_null($yesterday)){
                $transaction->view_count_daily = 0;
                $transaction->subscriber_count_daily = 0;
            } else {
                $transaction->view_count_daily = $transaction->view_count - $yesterday->view_count;
                $transaction->subscriber_count_daily = $transaction->subscriber_count - $yesterday->subscriber_count;
            }
        });
    }
}
