<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'comment' => CommentResource::collection($this->comments),
            'user' => new UserResource($this->user)
        ];
    }
}
