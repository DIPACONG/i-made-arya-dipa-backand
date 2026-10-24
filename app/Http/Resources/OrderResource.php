<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'method'    => $this->method,
            'total'     => (float) $this->total,
            'status'    => $this->status,
            'items'     => is_array($this->items) ? $this->items : (json_decode($this->items, true) ?? []),
            'createdAt' => $this->created_at?->toISOString() ?? (string) $this->created_at,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
