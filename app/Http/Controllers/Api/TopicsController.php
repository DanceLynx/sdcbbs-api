<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\TopicQuery;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function show($topicId,TopicQuery $topicQuery)
    {
        $topic = $topicQuery->findOrFail($topicId);
        return new TopicResource($topic);
    }


    public function index(Request $request,TopicQuery $topicQuery)
    {
        $topics = $topicQuery->paginate();
        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request,User $user,TopicQuery $topicQuery)
    {

        $topics = $topicQuery->where('user_id',$user->id)->paginate();

        return TopicResource::collection($topics);
    }

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

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy',$topic);

        $topic->delete();

        return response(null,204);
    }
}
