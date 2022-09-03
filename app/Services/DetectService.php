<?php

namespace App\Services;

class DetectService
{
    public static function get(int $video_id, float $offset)
    {
        $cache_key = 'video:' . $video_id . ':offset:' . $offset;
        if (!$data = \Cache::get($cache_key)) {
            $data = RecognitionService::getData($video_id, $offset);
            \Cache::remember($cache_key, 3600, fn() => $data);
        }
        return $data;
    }
}
