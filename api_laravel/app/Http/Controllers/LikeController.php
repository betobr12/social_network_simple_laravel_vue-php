<?php

namespace App\Http\Controllers;

use App\Libraries\DataIndex;
use App\Models\Content;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected function like(Request $request, $id)
    {
        $user           = $request->user();
        $contents       = new DataIndex();
        $content = Content::find($id);
        $like_count = 0;

        if ($like = Like::where('content_id', '=', $content->id)->where('user_id', '=', $user->id)->whereNull('deleted_at')->first()) {
            $like->delete();
            $like_count = $like->count_like($content->id)[0];
            return array(
                "status" => true, 
                "likes" => $like_count->count_like,
                "content" => $contents->getContent()
            );
        }

        if ($like = Like::create([
            'user_id'      => $user->id,
            'content_id'   => $content->id,
            'created_at'   => \Carbon\Carbon::now()
        ])) {
            $like_count = $like->count_like($content->id)[0];
            return array(
                "status"  => true, 
                "likes"   => $like_count->count_like,
                "content" => $contents->getContent()
            );
        }
    }

    protected function like_page(Request $request, $id)
    {
        $user               = $request->user();
        $contents           = new DataIndex();
        $content            = Content::find($id);
        $contents->user_id  = $content->user_id;
        $like_count = 0;

        if ($like = Like::where('content_id', '=', $content->id)->where('user_id', '=', $user->id)->whereNull('deleted_at')->first()) {
            $like->delete();
            $like_count = $like->count_like($content->id)[0];
            return array(
                "status"  => true, 
                "likes"   => $like_count->count_like,
                "content" => $contents->getContent()
            );
        }

        if ($like = Like::create([
            'user_id'      => $user->id,
            'content_id'   => $content->id,
            'created_at'   => \Carbon\Carbon::now()
        ])) {
            $like_count = $like->count_like($content->id)[0];
            return array(
                "status"  =>true,
                "likes"   => $like_count->count_like,
                "content" =>$contents->getContent()
            );
        }        
    }
}
