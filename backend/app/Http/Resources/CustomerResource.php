<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'start_date' => $this->start_date->format('Y-m-d'),
            'description' => $this->description,
            'category' => $this->category->name,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ], $this->includeContactInfo($request));
    }

    protected function includeContactInfo(Request $request): array
    {
        if ($request->routeIs('customers.show')) {
            return [
                'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
            ];
        }

        return [
            'contacts_count' => $this->contacts_count,
        ];
    }
}
