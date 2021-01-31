<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class events extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'start'         => $this->start,
            'end'           => $this->end,
            'color'         => $this->color,
            'timed'         => $this->timed,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
