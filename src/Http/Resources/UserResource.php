<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => (int) $this->id,
            'client'      => (is_null($this->client_id) ? new ClientResource($this->client) : (int) $this->client_id),
            'roles'       => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($this->permissions),
            'name'        => $this->name,
            'email'       => $this->email,
        ];
    }
}
