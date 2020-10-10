<?php

namespace App\Handlers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    /**
     * @param UploadedFile $file
     * @param string $folder
     * @param string $prefix
     * @param null $maxWidth
     * @param bool $isFullUrl
     * @return mixed
     */
    public function save(UploadedFile $file, $folder = 'images', $prefix = '', $maxWidth = null, $isFullUrl = false)
    {
        $disk = 'public';
        if(! $prefix) {
            $prefix = Str::random(10);
        }
        $folder .= '/' . date('Y/m');
        $ext = $file->extension() ?: 'png';
        $name = $prefix . '_' . Str::random() . '_' . time() . '.' . $ext;
        $shortPath = $file->storeAs($folder, $name, $disk);

        if($maxWidth && $ext !== 'gif') {
            $this->resize(Storage::disk($disk)->path($shortPath), $maxWidth);
        }

        return $isFullUrl ? Storage::disk($disk)->url($shortPath) : $shortPath;
    }

    protected function resize($filePath, $width = 400)
    {
        $img = Image::make($filePath);

        $img->resize($width, null, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save();
    }

    public function resizeImg($img, $width = 200, $disk = 'public')
    {
        $path = Storage::disk($disk)->path($img);
        if($path) {
            $this->resize($path, $width);
        }
    }
}
