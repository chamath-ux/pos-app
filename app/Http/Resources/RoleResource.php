<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'name'=>$this->whenNotNull($this->name),
            'userName'=>$this->whenNotNull($this->first_name),
            'permissions'=> RoleResource::collection($this->whenLoaded('rolePermissions')),
            'users'=> RoleResource::collection($this->whenLoaded('users'))
        ];
    }
}
