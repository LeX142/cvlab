<?php

namespace App\Services;


use Illuminate\Support\Facades\Redis;

class ParseContent
{

    private mixed $video;
    private array $data;
    private $redis;

    public function __construct($video, string $json)
    {
        $this->data = json_decode($json, true);
        $this->video = $video;
        $this->redis = Redis::connection();
    }

    public function handle(): array
    {
        if (!empty($this->data)) {
            $products = [];
            foreach ($this->data as $person_data) {
                if (empty($person_data['id'])) {
                    continue;
                }
                foreach ($person_data['clothes'] as $product_data) {
                    if (!empty($product_data['similar'])) {
                        foreach ($product_data['similar'] as $number => $productSimilar) {
                            $product_id = $product_data['id'];
                            $products[$product_id][] = [
                                'id' => $product_id,
                                'image_url' => trim($productSimilar['image']),
                                'store_url' => trim($productSimilar['product']),
                                'name' => mb_substr($productSimilar['title'] ?? $productSimilar['id'], 0, 64),
                                'category' => implode('-', $productSimilar['category']),
                                'brand' => $productSimilar['brand'],
                                'score' => $productSimilar['score'],
                            ];
                        }
                    }
                }

            }
            return $products;
        }

        return [];
    }


}
