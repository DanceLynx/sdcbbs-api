<?php
/*
 * @Author: DanceLynx
 * @Description: 回复观察类
 * @Date: 2020-06-25 23:12:51
 */

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content);
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        // $reply->topic->increment('reply_count', 1);
        $reply->topic->updateReplyCount();
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
