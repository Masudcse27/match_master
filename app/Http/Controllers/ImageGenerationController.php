<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StableDiffusionService;
use Illuminate\Support\Facades\Log;

class ImageGenerationController extends Controller
{
    protected $stableDiffusionService;

    public function __construct(StableDiffusionService $stableDiffusionService)
    {
        $this->stableDiffusionService = $stableDiffusionService;
    }

    public function generate(Request $request)
    {
        // Get the text from the request
        $prompt = $request->input('prompt', 'ultra realistic portrait with your text');
        $negativePrompt = $request->input('negative_prompt', 'ugly, deformed');

        // Log for debugging
        Log::info("Generating image with prompt: $prompt and negative prompt: $negativePrompt");

        // Call the StableDiffusionService to generate the image
        $result = $this->stableDiffusionService->generateImage($prompt, $negativePrompt);

        if (isset($result['error'])) {
            Log::error("Image generation error: " . $result['error']);
            return response()->json(['error' => $result['error']], 500);
        }

        if (isset($result['image_url'])) {
            return response()->json(['image_url' => $result['image_url']]);
        }

        Log::error("Image URL not found in the response.");
        return response()->json(['error' => 'Image URL not found.'], 500);
    }
}
