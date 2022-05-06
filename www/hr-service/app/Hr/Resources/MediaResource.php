<?php

namespace App\Hr\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->timestamp,
            'media_type_id' => $this->media_type_id,
        ];
    }
}
