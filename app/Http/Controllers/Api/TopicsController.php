<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index(Request $request,Topic $topic)
    {
        $topics = QueryBuilder::for(Topic::class)
            ->allowedIncludes(['user','category'])
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder')->default('recentReplies'),
            ])
            ->paginate();

        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request,User $user)
    {
        $query = $user->topics()->getQuery();

        $topics = QueryBuilder::for($query)
            ->allowedIncludes(['user','category'])
            ->allowedFilters([
                'title',
                AllowedFilter::scope('withOrder')->default('recentReplies'),
                AllowedFilter::exact('category_id'),
            ])->paginate();

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
