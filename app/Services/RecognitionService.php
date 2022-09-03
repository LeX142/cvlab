<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class RecognitionService
{
    public static string $url = 'https://cvpro_handle.dress-coder.ru';

    /**
     * @throws \Exception
     */
    public static function getData($video_id, $offset)
    {
        $cacheKey = self::getCacheKey($video_id, $offset);
        if (!$data = Cache::get($cacheKey)) {
            $json = self::getJson($video_id, $offset);
            $data = (new ParseContent($video_id, $json))->handle();
            $data = [
                'screenshot'=>self::$url.'/frame/'.$video_id.'/'.$offset,
                'products'=>$data
            ];
            Cache::remember($cacheKey, 300, fn() => $data);
        }
        return $data;
    }

    public static function getJson($video_id, $offset)
    {
        return file_get_contents(self::$url . '/meta/' . $video_id . '/' . $offset);
    }

    public static function getCacheKey($video_id, $offset): string
    {
        return $video_id . ':' . $offset;
    }
}
