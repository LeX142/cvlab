<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetectRequest;
use App\Services\RecognitionService;

class DetectController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index(DetectRequest $request, string $video_id, string $offset): \Illuminate\Http\JsonResponse
    {
        return response()->json(RecognitionService::getData(...$request->validated()));
    }
}
