<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'online_status' => $this->when($this->online_status, 'Online', 'OFFline'),
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->when($this->registration_end_date, $this->registration_end_date),
            'fees' => $this->fees,
            'payments' => $this->payments,
            'creator_id' => $this->creator_id,
            'creator_name' => $this->creator->name,
        ];
    }
}
