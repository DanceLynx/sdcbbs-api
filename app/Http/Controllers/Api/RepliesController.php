<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\ReplyQuery;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function index($topicId, ReplyQuery $replyQuery)
    {
        $replies = $replyQuery->where('topic_id',$topicId)->paginate();
        return ReplyResource::collection($replies);
    }

    public function userIndex($userId,ReplyQuery $replyQuery)
    {
        $replies = $replyQuery->where('user_id',$userId)->paginate();
        return ReplyResource::collection($replies);
    }

    public function store(ReplyRequest $request,Topic $topic,Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();
        return new ReplyResource($reply);
    }

    public function destroy(Topic $topic,Reply $reply)
    {
        if($topic->id != $reply->topic_id){
            abort(404);
        }
        $this->authorize('destroy',$reply);
        $reply->delete();
        return response(null,204);
    }
}
