<?php
/*
 * @Author: DanceLynx
 * @Description: 话题数据操作触发
 * @Date: 2020-06-22 08:36:33
 */

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
        $topic->body = clean($topic->body, 'user_topic_body');
    }

    public function saved(Topic $topic)
    {
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }

    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
