<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }
}
