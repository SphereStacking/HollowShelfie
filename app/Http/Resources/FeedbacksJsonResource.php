<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbacksJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int, mixed>
     */
    public function toArray(Request $request): array
    {
        $processedResponses = [];
        foreach ($this->resource as $response) {
            $answers = [];
            $answers['debug'] = $response;
            $answers['respondentEmail'] = $response->getRespondentEmail();
            $answers['gravatar_url'] = config('external_services.gravatar.profile').md5(strtolower(trim($response->getRespondentEmail())));
            $answers['comment'] = $response['answers']['35fdddf5']['textAnswers']['answers'][0]->value;
            $processedResponses[] = $answers;
        }

        return $processedResponses;
    }
}
