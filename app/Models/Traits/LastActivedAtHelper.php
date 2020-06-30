<?php


namespace App\Models\Traits;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    // 缓存相关
    protected $hash_prefix = 'sdcbbs_laravel_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActiveTime()
    {
        $date = Carbon::now()->toDateString();
        $hash = $this->hash_prefix.$date;
        $field = $this->field_prefix.\Auth::id();
        $now = Carbon::now()->toDateTimeString();
        Redis::hSet($hash,$field,$now);
    }

    public function syncUserActivedAt()
    {
        $yesterday_date = Carbon::yesterday()->toDateString();
        $hash = $this->hash_prefix.$yesterday_date;
        $all = Redis::hGetAll($hash);
        if(empty($all)){
            $today = Carbon::now()->toDateString();
            $hash = $this->hash_prefix.$today;
            $all = Redis::hGetAll($hash);
        }
        foreach ($all as $user_id => $time){
            $user_id = str_replace($this->field_prefix,'',$user_id);
            if($user = User::find($user_id)){
                $user->last_actived_at = $time;
                $user->save();
            }
        }
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        $date = Carbon::now() ->toDateString();
        $hash = $this->hash_prefix.$date;
        $field = $this->field_prefix.$this->id;
        $datetime = Redis::hGet($hash,$field)?:$value;

        if($datetime){
            return new Carbon($datetime);
        }else{
            return $this->created_at;
        }
    }
}