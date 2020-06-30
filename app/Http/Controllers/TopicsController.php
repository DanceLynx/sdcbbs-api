<?php
/*
 * @Author: DanceLynx
 * @Description: 帖子控制器
 * @Date: 2020-06-22 08:36:33
 */

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request,Topic $topic, User $user,Link $link)
    {
        $topics = $topic
            ->withOrder($request->order)
            ->with('user', 'category')
            ->paginate();
        $active_users = $user->getActiveUsers();
        $links = $link->getCachedLinks();
        return view('topics.index', compact('topics','active_users','links'));
    }

    public function show(Request $request,Topic $topic)
    {
        if(! empty($topic->slug) && $topic->slug != $request->slug){
            return redirect($topic->link(),301);
        }
        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

    public function store(TopicRequest $request,Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = \Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with('success', '创建成功.');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->to($topic->link())->with('success', '更新成功');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '删除成功');
    }

    public function uploadImage(Request $request,ImageUploadHandler $uploadHandler)
    {
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => ''
        ];
        if(! $file = $request->upload_file){
            return \response()->json($data);
        }

        $result = $uploadHandler->save($file,'topics',\Auth::id(),1024);
        if(! $result) return \response()->json($data);
        $data['success'] = true;
        $data['msg']  = '上传成功';
        $data['file_path'] = $result['path'];
        return \response()->json($data);
    }
}
