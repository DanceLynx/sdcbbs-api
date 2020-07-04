<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function store(TopicRequest $topicRequest,Topic $topic)
    {
        $topic->fill($topicRequest->all());
        $topic->user_id = \Auth::id();
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $topicRequest,Topic $topic)
    {
        $this->authorize('update',$topic);

        $topic->update($topicRequest->all());

        return new TopicResource($topic);
    }
}
