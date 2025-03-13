<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'content_id' => $this->content_id,
            'content' => new ContentResource($this->whenLoaded('content')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

