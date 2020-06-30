<?php
/*
 * @Author: DanceLynx
 * @Description: 分类控制器
 * @Date: 2020-06-22 10:34:22
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request,Topic $topic,User $user,Link $link)
    {
        $topics = $topic
            ->withOrder($request->order)
            ->with('category', 'user')
            ->where('category_id', $category->id)
            ->paginate(20);
        $active_users = $user->getActiveUsers();
        $links = $link->getCachedLinks();
        return view('topics.index', compact('topics', 'category','active_users','links'));
    }
}
