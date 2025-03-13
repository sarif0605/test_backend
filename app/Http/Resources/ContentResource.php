<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content ?? null,
            'image_url' => $this->image_url ?? null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

