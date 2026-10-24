<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Sesuai format Resource di Bab 3.4.5 Modul dan kompatibel langsung dengan React Frontend.
     */
    public function toArray(Request $request): array
    {
        $imageUrl = $this->imageUrl;

        return [
            'id'           => $this->photo_id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'category_id'  => $this->category_id,
            'category'     => $this->category?->category ?? '',
            'category_detail' => [
                'id'       => $this->category_id,
                'category' => $this->category?->category,
            ],
            'photographer' => $this->photographer,
            'tags'         => is_array($this->tags) ? $this->tags : (json_decode($this->tags, true) ?? []),
            'w'            => (int) $this->w,
            'h'            => (int) $this->h,
            'price'        => (float) $this->price,
            'downloads'    => (int) $this->downloads,
            'img'          => $this->img,
            'img_url'      => $imageUrl,
            'thumb'        => $imageUrl,
            'preview'      => $imageUrl,
            'full'         => $imageUrl,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
