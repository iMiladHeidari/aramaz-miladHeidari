<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GenerateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-thumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for images in a existing_images directory.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Define the path to the existing images directory
        $images_directory = public_path('/existing_images');

        // Check if the directory exists
        if (!is_dir($images_directory)) {
            // If the directory does not exist, display an error message and exit
            echo 'Error: The directory ' . $images_directory . ' does not exist.';
            exit;
        }

        // Define the path for saving thumbnails after resizing
        $thumbnail_directory = '/thumbnails';

        // Define the desired dimensions for the thumbnails
        $width = 100;
        $height = 100;

        // Get an array of all the files in the existing images directory
        $images = File::allFiles($images_directory);

        // Shuffle the array of image files randomly
        shuffle($images);

        // Get only the first 10 elements of the shuffled array
        $images = array_slice($images, 0, 10);

        // Loop through each image file in the directory
        foreach ($images as $image) {
            // Get the absolute path to the image file
            $image_abs_path = $image->getRealPath();

            // Generate the absolute path to the corresponding thumbnail file
            $thumbnail_abs_path = $thumbnail_directory . '/' . basename($image);

            // If the thumbnail file already exists, skip this iteration
            if (file_exists($thumbnail_abs_path)) {
                continue;
            }

            // Load the image using the Intervention Image library
            $image = Image::make($image_abs_path);

            // Resize and crop the image to fit the desired dimensions
            $image->fit($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save the thumbnail file to disk using the Storage facade
            Storage::put($thumbnail_abs_path, $image->stream());
        }

        echo 'Thumbnails generated successfully!';
    }
}
