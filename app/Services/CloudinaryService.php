<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    public static function uploadImage($file, $folder)
    {
        try {
            $uploadResponse = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'transformation' => [['quality' => 'auto', 'fetch_format' => 'auto']]
            ]);
            return $uploadResponse->getSecurePath();
        } catch (\Exception $e) {
            Log::error("Lỗi upload lên Cloudinary: " . $e->getMessage());
            return null;
        }
    }

    public static function deleteImage($url)
    {
        if ($url) {
            preg_match('/\/v\d+\/(.+?)\.\w+$/', $url, $matches);

            if (!empty($matches[1])) {
                $publicId = $matches[1];
                Log::info("Public ID: " . $publicId);

                try {
                    Cloudinary::destroy($publicId);
                    Log::info("Xóa ảnh trên Cloudinary thành công: " . $publicId);
                } catch (\Exception $e) {
                    Log::error("Lỗi khi xóa ảnh trên Cloudinary: " . $e->getMessage());
                }
            } else {
                Log::error("Không tìm thấy Public ID hợp lệ trong URL: " . $url);
            }
        }
    }
}
