<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['title','link'];
    public $cache_key = 'laravel_cache_links';
    protected $expire_in_seconds = 1440*60;

    public function getCachedLinks()
    {
        return \Cache::remember($this->cache_key,$this->expire_in_seconds,function (){
            return $this->all();
        });
    }
}
