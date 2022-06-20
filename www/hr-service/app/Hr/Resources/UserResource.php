<?php

namespace App\Hr\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'profile_photo_path' => $this->profile_photo_path,
            'title' => $this->title,
            'phone' => $this->phone,
            'email_verified_at' => $this->email_verified_at,
            'disabled_at' => !empty($this->disabled_at->timestamp) ? $this->disabled_at->timestamp : null,
            'role' => new RoleResource($this->roles->first()),
        ];
    }
}
