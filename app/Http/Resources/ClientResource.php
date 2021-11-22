<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_type_id' => $this->userType,
            'is_verified' => $this->is_verified,
            'address' => $this->address,
            'registered_address' => $this->registered_address,
            'is_public_entity' => $this->is_public_entity,
            'nature_of_business' => $this->nature_of_business,
            'doubts' => $this->doubts,
            'consultant_id' => $this->consultant,

        ];
    }
}
