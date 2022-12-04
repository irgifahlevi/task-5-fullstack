<?php

namespace App\Http\Resources\Articles;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailArticlesResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'image'         => $this->image,
            'user_id'       => $this->user_id,
            'category_id' => $this->whenLoaded('kategori'),
            'created_at' => date_format($this->created_at, "d/m/Y H:i:s"),
            'updated_at' => date_format($this->updated_at, "d/m/Y H:i:s"),
        ];
    }
}
