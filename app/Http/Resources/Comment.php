<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'text'=>$this->text,
            'user'=>'/api/users/'.User::find($this->user_id),
            'article'=>'/api/articles/'.$this->article_id,
            'created_at'=>$this->created_at,
            'updated_ar'=>$this->updated_at,
        ];
    }
}
