<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AuctioneerResource  extends Resource
{
    /**
     * @SWG\Get(path="/demo/demo",
     *   tags={"demo"},
     *   summary="",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="name", in="query", default="", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        $data = parent::toArray($request);
        echo '<pre>';
        print_r($data);
    }
}
