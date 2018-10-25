<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class initSources extends JsonResource
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
            'sourceID' => $this->sourceID,
            'sourceName' => $this->sourceName,
            'active' => ($this->active) ? $this->active : false
        ];
    }
}
