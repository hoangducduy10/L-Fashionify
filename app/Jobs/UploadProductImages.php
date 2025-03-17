<?php

namespace App\Jobs;

use App\Models\ProductImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imagePath;
    protected $productId;

    public function __construct($imagePath, $productId)
    {
        $this->imagePath = $imagePath;
        $this->productId = $productId;
    }

    public function handle()
    {
        $uploadResponse = Cloudinary::upload($this->imagePath, [
            'folder' => 'products/images',
            'transformation' => [['quality' => 'auto', 'fetch_format' => 'auto']]
        ]);

        $imageUrl = $uploadResponse->getSecurePath();

        ProductImage::create([
            'product_id' => $this->productId,
            'url' => $imageUrl
        ]);
    }
}
