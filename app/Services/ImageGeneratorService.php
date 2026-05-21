<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageGeneratorService
{
    /**
     * Fetch and save product image from Unsplash API or generate placeholder
     */
    public static function fetchProductImage($productName)
    {
        try {
            $apiKey = env('UNSPLASH_ACCESS_KEY');

            // Try Unsplash API first if key is configured
            if (!empty($apiKey)) {
                $imageUrl = self::fetchFromUnsplash($productName, $apiKey);
                if ($imageUrl) {
                    return self::downloadAndSaveImage($imageUrl, $productName);
                }
            }

            // Fallback to Lorem Picsum (no API key needed)
            return self::generatePlaceholderImage($productName);
        } catch (\Exception $e) {
            Log::error('Image generation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch image from Unsplash API
     */
    private static function fetchFromUnsplash($productName, $apiKey)
    {
        try {
            $response = Http::timeout(10)->get('https://api.unsplash.com/search/photos', [
                'query' => $productName,
                'per_page' => 1,
                'client_id' => $apiKey,
            ]);

            if ($response->successful() && count($response->json('results')) > 0) {
                return $response->json('results.0.urls.regular');
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('Unsplash API error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate placeholder image using Lorem Picsum
     */
    private static function generatePlaceholderImage($productName)
    {
        try {
            // Use Lorem Picsum for placeholder images
            $random = rand(1, 1000);
            $imageUrl = "https://picsum.photos/600/400?random={$random}&t=" . urlencode($productName);

            $imageName = time() . '_' . Str::slug($productName) . '.jpg';
            $imageContent = Http::timeout(30)->get($imageUrl)->body();

            if ($imageContent && strlen($imageContent) > 1000) { // Verify we got valid image data
                Storage::disk('public')->put('products/' . $imageName, $imageContent);
                return 'products/' . $imageName;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Placeholder image error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Download image from URL and save locally
     */
    private static function downloadAndSaveImage($imageUrl, $productName)
    {
        try {
            $imageContent = Http::timeout(30)->get($imageUrl)->body();

            if ($imageContent) {
                $imageName = time() . '_' . Str::slug($productName) . '.jpg';
                Storage::disk('public')->put('products/' . $imageName, $imageContent);

                return 'products/' . $imageName;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Image download error: ' . $e->getMessage());
            return null;
        }
    }
}
