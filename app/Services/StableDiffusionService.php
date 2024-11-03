<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StableDiffusionService
{
    protected $apiUrl = 'https://stablediffusionapi.com/api/v4/dreambooth'; // Update with your endpoint
    protected $apiKey = 'your_api_key_here'; // Replace with your API key

    public function generateImage($prompt, $negativePrompt)
    {
        $response = Http::post($this->apiUrl, [
            'key' => $this->apiKey,
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
        ]);

        return $response->json();
    }
}
