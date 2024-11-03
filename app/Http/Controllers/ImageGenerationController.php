<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StableDiffusionService;

class ImageGenerationController extends Controller
{
    protected $stableDiffusionService;

    public function __construct(StableDiffusionService $stableDiffusionService)
    {
        $this->stableDiffusionService = $stableDiffusionService;
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt', 'ultra realistic portrait');
        $negativePrompt = $request->input('negative_prompt', 'ugly, deformed');

        $result = $this->stableDiffusionService->generateImage($prompt, $negativePrompt);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        if (isset($result['image_url'])) {
            return response()->json(['image_url' => $result['image_url']]);
        }

        return response()->json(['error' => 'Image URL not found.'], 500);
    }
}
