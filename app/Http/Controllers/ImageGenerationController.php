<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\StableDiffusionService;

class ImageGenerationController extends Controller
{
    protected $stableDiffusionService;

    public function __construct(StableDiffusionService $stableDiffusionService)
    {
        $this->stableDiffusionService = $stableDiffusionService;
    }

    public function generateImage(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        try {
            $prompt = $request->input('prompt');
            $options = $request->except('prompt');
            $imageResponse = $this->stableDiffusionService->generateImage($prompt, $options);

            return response()->json($imageResponse);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}