<?php

namespace App\Interfaces\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'read_date' => $this->read_date->format('Y-m-d'),
            'impression' => $this->impression,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
