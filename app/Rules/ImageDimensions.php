<?php
namespace App\Rules;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
class ImageDimensions implements Rule
{
    protected $otherImage;
    protected $user;
    protected $requiredWidthPx;
    protected $requiredHeightPx;
    protected $maxWidthPx = 1500;
    protected $maxHeightPx = 1000;

    public function __construct($otherImage, $user)
    {
        $this->otherImage = $otherImage;
        $this->user = $user;

        // Set minimum required dimensions (converted from mm to pixels at approx 600 DPI for reference)
        $this->requiredWidthPx = 900; // Minimum width in pixels
        $this->requiredHeightPx = 700; // Minimum height in pixels
    }

    public function passes($attribute, $value)
    {
        if (!$this->otherImage) {
            
            return true;
        }

        try {
            // Create image instances for validation
            $image1 = Image::read($value);
            $image2 = Image::read($this->otherImage);

            // 1. Check pixel dimensions are within the allowable range
            if (!$this->checkDimensions($image1) || !$this->checkDimensions($image2)) {
                return false;
            }

            // 2. Validate Exif data to match user name (optional)
            if (!$this->checkExifData($value) || !$this->checkExifData($this->otherImage)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Image validation error: ' . $e->getMessage());
            return false;
        }
    }

    // Check dimensions in pixels within a range
    protected function checkDimensions($image)
    {
        $width = $image->width();
        $height = $image->height();

        return ($width >= $this->requiredWidthPx && $width <= $this->maxWidthPx) &&
            ($height >= $this->requiredHeightPx && $height <= $this->maxHeightPx);
    }

    // Read and validate Exif author data matches the user
    protected function checkExifData($imagePath)
    {
        $exif = @exif_read_data($imagePath);

        if ($exif && isset($exif['Artist'])) {
            return strtolower($exif['Artist']) === strtolower($this->user->name);
        }

        // No Exif or no Artist data, consider it a pass
        return true;
    }

    public function message()
    {
        return 'The images must meet Kenya ID card specifications: minimum 785x491 pixels and maximum 800x600 pixels, and the name should match the registered user.';
    }
}

// class ImageDimensions implements Rule
// {
//     protected $otherImage;

//     public function __construct($otherImage)
//     {
//         $this->otherImage = $otherImage; 
//     }

     
//     public function passes($attribute, $value)
//     {
//         // Check if the other image is provided
//         if (!$this->otherImage) {
//             return true; ;
//         }

//         // Get dimensions of both images
//         $image1 = Image::read($value);
//         $image2 = Image::read($this->otherImage);

//         return $image1->width() === $image2->width() && $image1->height() === $image2->height();
//     }

//     public function message()
//     {
//         return 'The images must have the same dimensions.';
//     }
// } 