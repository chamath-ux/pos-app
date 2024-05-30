<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'first_name'=>$this->whenNotNull($this->first_name),
            'last_name'=>$this->whenNotNull($this->last_name),
            'name'=>$this->whenNotNull($this->name),
            'role'=>new RoleResource($this->whenLoaded('role')),
            'userPermissions'=>AuthResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
