<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Person extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // return [
        //     'person_id' => $this->person_id,
        //     'fullname' => $this->lastname .', '. $this->firstname .' '. $this->middlename,
        // ];
    }

    // public function with($request){
    //     return [
    //         'version' => '1.0.0',
    //         'author' => 'Jabez Ian Chris Peñalver'
    //     ];
    // }

}
