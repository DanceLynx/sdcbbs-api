<?php


namespace App\Models\Traits;


use App\Models\Reply;
use App\Models\Topic;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Arr;

trait UserActiveHelper
{
    // 用于存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $topics_weigh = 4; //话题权重
    protected $replies_weigh = 1; // 回复权重
    protected $pass_days = 7; // 多少天内发表国内容
    protected $user_number = 6; // 结果取出多少个用户

    // 缓存配置
    protected $cache_key = 'laravel_active_users';
    protected $cache_expire_in_seconds = 65*60;

    public function getActiveUsers()
    {
        return \Cache::remember($this->cache_key,$this->cache_expire_in_seconds,function (){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        $active_users = $this->calculateActiveUsers();
        $this->cacheActiveUsers($active_users);
    }
    protected function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        // 数组按照得分排序
        $users = \Arr::sort($this->users,function ($user){
            return $user['score'];
        });

        // 我们需要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users,true);

        // 只获取我们想要的数量
        $users = array_slice($users,0,$this->user_number,true);

        // 创建一个空集合
        $active_users = collect();
        foreach ($users as $user_id => $user){
            $user = $this->find($user_id);
            if($user){
                $active_users->push($user);
            }
        }
        return $active_users;
    }

    protected function calculateTopicScore()
    {
        // 从话题数据表里取出限定时间范围（$pass_days）内，有发表过话题的用户
        // 并且同时取出用户此段时间内发布话题的数量
        $topic_users = Topic::query()
            ->select(\DB::raw("user_id,count(*) as topic_count"))
            ->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($topic_users as $value){
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topics_weigh;
        }
    }

    public function calculateReplyScore()
    {
        $reply_users = Reply::query()
            ->select(\DB::raw("user_id,count(*) as reply_count"))
            ->where("created_at",'>=',Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        foreach ($reply_users as $value){
            $reply_score = $value->reply_count * $this->replies_weigh;
            if(isset($this->users[$value->user_id])){
                $this->users[$value->user_id]['score'] += $reply_score;
            }else{
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    protected function cacheActiveUsers($active_users)
    {
        return \Cache::put($this->cache_key,$active_users,$this->cache_expire_in_seconds) ;
    }

}
