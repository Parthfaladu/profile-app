<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\{WorkExperianceResource, OrganizationResource};

class UserResource extends JsonResource
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
            "userId"          => $this->id,
            "firstName"       => $this->first_name,
            "lastName"        => $this->last_name,
            "email"           => $this->email,
            "workExperiences" => WorkExperianceResource::collection($this->workexperiances),
            "organizations"   => OrganizationResource::collection($this->organizationassociation),
        ];
    }
}
