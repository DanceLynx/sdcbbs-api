<?php
/*
 * @Author: DanceLynx
 * @Description: 帖子模型
 * @Date: 2020-06-22 08:36:33
 */

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case "recent":
                $this->scopeRecent($query);
                break;
            default:
                $this->scopeRecentReplied($query);
                break;
        }
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
