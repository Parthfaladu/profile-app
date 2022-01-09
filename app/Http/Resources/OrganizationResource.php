<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            "id"                  => $this->id,
            "name"                => $this->name,
            "associatedAs"        => $this->assocciated_as,
            "startedAt"           => [
                "month" => Carbon::parse($this->start_at)->isoFormat('M'),
                "year" => Carbon::parse($this->start_at)->format('Y'),
            ],
            "endAtCurrentWorking" => $this->end_at_current_work,
            "description"         => $this->description,
            "userId"              => $this->user_id,
        ];

        if($this->end_at_current_work === false && $this->end_at)
        {
            $response["endAt"]["month"] = Carbon::parse($this->end_at)->isoFormat('M');
            $response["endAt"]["year"]  = Carbon::parse($this->end_at)->format('Y');
        }
        else {
            $response["endAt"]["month"] = null;
            $response["endAt"]["year"]  = null;
        }
        return $response;
    }
}
