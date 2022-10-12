<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'titulo ' => $this->title,
            'usuario_publicador' => [
                'id' => $this->publisher->id,
                'nome' => $this->publisher->name,
            ],
            'indices' => BookIndexResource::collection($this->index),
        ];
    }
}
