<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StableDiffusionService
{
    public function generateImage($prompt, $negativePrompt)
    {
        $apiKey = env('STABLE_DIFFUSION_API_KEY'); // Make sure to add your API key to the .env file
        $url = 'https://stablediffusionapi.com/api/v4/dreambooth';

        $payload = [
            'key' => $apiKey,
            'model_id' => 'stable-diffusion-xl-base-1.0',
            'prompt' => $prompt,
            'negative_prompt' => $negativePrompt,
            'width' => '512',
            'height' => '512',
            'samples' => '1',
            'num_inference_steps' => '30',
            'guidance_scale' => 7.5,
            'safety_checker' => 'no',
            'enhance_prompt' => 'yes',
        ];

        $response = Http::post($url, $payload);

        if ($response->failed()) {
            return ['error' => 'Failed to connect to the API.'];
        }

        return $response->json();
    }
}
