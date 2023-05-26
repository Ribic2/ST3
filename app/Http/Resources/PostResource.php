<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post' => $this->post,
            'created_by' => User::where('id', '=', $this->user_id)->first()->toArray(),
            'comments' => CommentResource::collection(Comment::where('post_id', '=', $this->id)->orderBy('created_at', 'desc')->get()),
            'likes' => Like::where('post_id', '=', $this->id)->get(),
        ];
    }
}
