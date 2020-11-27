<?php

namespace Modules\Central\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $arrayDomain = collect(explode('.', $this->domain));
        $link = $arrayDomain->count() > 1 ? $this->domain : sprintf("%s.%s", $this->domain, config('central.domain'));

        $obj = [
            "id" => $this->uuid,
            "name" => $this->name,
            "document" => $this->document,
            "domain" => $link,
        ];

        return $obj;
    }
}
