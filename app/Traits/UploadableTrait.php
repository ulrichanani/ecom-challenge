<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadableTrait
{
    /**
     * @param UploadedFile $file
     * @param string       $folder
     * @param string       $disk
     * @return false|string
     */
    public function storeFile(UploadedFile $file, $folder = 'product_images', $disk = 'public')
    {
        return $file->store($folder, ['disk' => $disk]);
    }

    /**
     * @param UploadedFile $file
     * @param string       $folder
     * @param string       $disk
     * @return false|string
     */
    public function storeProductImage(UploadedFile $file)
    {
        return str_replace_first('product_images/', '', $file->store('product_images', ['disk' => 'public']));
    }

    /**
     * @param UploadedFile $file
     * @param string       $folder
     * @param string       $disk
     * @param null         $filename
     * @return false|string
     */
    public function storeFileAs(UploadedFile $file, $folder = 'product_images', $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        return $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            $disk
        );
    }
}
