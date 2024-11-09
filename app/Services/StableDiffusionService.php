<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StableDiffusionService
{
    protected $apiUrl = 'https://stablediffusionapi.com/api/v3/text2img';

    public function generateImage($prompt, $options = [])
    {
        $payload = array_merge([
            "key" => env('STABLE_DIFFUSION_API_KEY'),
            "prompt" => $prompt,
            "width" => "512",
            "height" => "512",
            "samples" => "1",
            "num_inference_steps" => "20",
            "guidance_scale" => 7.5,
            "safety_checker" => "yes",
            "multi_lingual" => "no",
            "panorama" => "no",
            "self_attention" => "no",
            "upscale" => "no",
            "seed" => null,
            "enhance_prompt" => "yes",
            "webhook" => null,
            "track_id" => null,
            "negative_prompt" => null
        ], $options);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Failed to generate image: " . $response->body());
    }
}