<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->image_path){
            $image = '/storage/' . $this->image_path;
        }
        elseif($this->image_url){
            $image = $this->image_url;
        }
        else{
            $image = '/assets/images/default-game.png';
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'image' => $image,
        ];
    }
}
