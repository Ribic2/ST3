<?php

namespace App\Http\Controllers;

use App\Events\UpdateComments;
use App\Events\UpdatePosts;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create new post
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'post' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Response(['error' => $validator->errors()], 400);
        }

        $newPost = Post::create([
            'post' => $request->get('post'),
            'user_id' => Auth::id()
        ]);

        broadcast(new UpdatePosts(PostResource::make($newPost)))->toOthers();

        return Response(['response' => PostResource::make($newPost)], 200);
    }

    /**
     * @return Response
     */
    public function getPosts(): Response
    {
        return Response(
            ['posts' => PostResource::collection(
                DB::select(sprintf("
                SELECT distinct p.* FROM posts p, friend_list fl
                WHERE p.user_id = fl.user_id
                AND fl.accepted = 1
                AND fl.friend_id = %s
                AND p.deleted_at IS null
                ORDER BY p.created_at DESC", Auth::id())))
            ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function likePost(Request $request): Response
    {
        $postId = $request->get('post_id');
        $isAdded = true;

        $check = Like::where([
            'post_id' => $postId,
            'user_id' => Auth::id()
        ]);

        if ($check->count() > 0) {
            $check->delete();
            $isAdded = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $postId
            ]);
        }

        return Response(["response" => $isAdded]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function commentPost(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'post_id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return Response(['error' => $validator->errors()], 400);
        }

        $comment = Comment::create([
            'post_id' => $request->get('post_id'),
            'comment' => $request->get('comment'),
            'user_id' => Auth::id()
        ]);

        broadcast(new UpdateComments(CommentResource::make($comment)))->toOthers();

        return Response(['response' => CommentResource::make($comment)]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deletePost(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return Response(["errors" => $validator->errors()], 400);
        }

        // Check if post was made by user
        $checkPostAuthor = Post::where('id', '=', $request->get('post_id'))->first();

        if ($checkPostAuthor->user_id != Auth::id()) {
            return Response(["error" => "Post was not made by you"], 401);
        }

        $checkPostAuthor->delete();

        return Response([
            "response" => $checkPostAuthor
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function updatePost(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|int',
            'post' => 'required|string'
        ]);

        if ($validator->fails()) {
            return Response(["errors" => $validator->errors()], 400);
        }

        // Check if post was made by user
        $checkPostAuthor = Post::where('id', '=', $request->get('post_id'))->first();

        if ($checkPostAuthor->user_id != Auth::id()) {
            return Response(["error" => "Post was not made by you"], 401);
        }

        $checkPostAuthor->update([
            'post' => $request->get('post')
        ]);

        return Response(
            [
                "response" => PostResource::make($checkPostAuthor)
            ]);
    }
}
