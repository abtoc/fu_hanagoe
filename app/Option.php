<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'id',
        'value',
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    static public function get(String $id, $default=null)
    {
        $option = Option::find($id);
        if(is_null($option)){
            return $default;
        }
        return $option->value;
    }
    static public function set(String $id, $value)
    {
        Option::updateOrCreate(['id' => $id], ['value' => $value]);
    }
}
