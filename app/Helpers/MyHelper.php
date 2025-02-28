<?php

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;



if (!function_exists('customUpload')) {
    function customUpload(UploadedFile $mainFile, string $uploadPath, ?int $reqWidth = null, ?int $reqHeight = null): array
    {
        try {
            $originalName     = pathinfo($mainFile->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtention    = $mainFile->getClientOriginalExtension();
            $currentTime      = Str::random(10) . time();
            $name = Str::limit($originalName, 100);
            $fileName = $currentTime . '.' . $fileExtention ;
            $fullUploadPath  = "public/$uploadPath";

            if (!Storage::exists($fullUploadPath)) {
                $localPath = storage_path("app/$fullUploadPath");
                if (!mkdir($localPath, 0755, true)) {
                    abort(404, "Failed to create the directory: $fullUploadPath");
                }
                // Ensure directory permissions are set correctly
                chmod($localPath, 0755);
            }

            // Store the file
            try {
                $mainFile->storeAs($fullUploadPath, $fileName);
                $filePath = "$uploadPath/$fileName";
            } catch (\Exception $e) {
                abort(500, "Failed to store the file: " . $e->getMessage());
            }


            $output = [
                'status'         => 1,
                'file_name'      => $fileName,
                'file_extension' => $mainFile->getClientOriginalExtension(),
                'file_size'      => $mainFile->getSize(),
                'file_type'      => $mainFile->getMimeType(),
                'file_path'      => $filePath,
            ];

            return array_map('htmlspecialchars', $output);
        } catch (\Exception $e) {
            return [
                'status' => 0,
                'error_message' => $e->getMessage(),
            ];
        }
    }
}


if (!function_exists('handaleFileUpload')) {
    /**
     * Handle file upload.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    function handaleFileUpload(UploadedFile $file, $folder = 'default')
    {
        if (!$file->isValid()) {
            abort(422, 'Invalid file');
        }

        $extension = $file->getClientOriginalExtension();
        $folderType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) ? 'images' : 'files';

        $path = Storage::disk('public')->put("$folderType/$folder", $file);

        if (!$path) {
            abort(500, 'Error occurred while moving the file');
        }

        // Return only the file path as a string
        return $path;
    }
}

if (!function_exists('handleFileUpdate')) {
    /**
     * Handle file upload and deletion of old files.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $fileKey
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $directory
     * @return string|null
     */
    function handleFileUpdate($request, $fileKey, $model, $directory)
    {
        if ($request->hasFile($fileKey)) {
            $oldFilePath = $model->$fileKey;
            if ($oldFilePath && File::exists(storage_path('app/public/' . $oldFilePath))) {
                File::delete(storage_path('app/public/' . $oldFilePath));
            }
            return handaleFileUpload($request->file($fileKey), $directory);
        }
        return $model->$fileKey;
    }
}

if (!function_exists('noImage')) {
    function noImage()
    {
        return 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg';
    }
}

if (!function_exists('generateCode')) {
    function generateCode($model, $prefix)
    {
        // Get the latest record from the specified model
        $lastRecord = $model::latest()->first();
        $code = 1;

        // Check for the highest existing code and increment it
        if ($lastRecord) {
            $lastNumericCode = intval(str_replace($prefix . '-', '', $lastRecord->student_id)); // Fix: Access correct column name
            $code = $lastNumericCode + 1;
        }

        // Generate a unique code
        $newCode = $prefix . '-' . $code;

        // Check if the generated code already exists
        while ($model::where('student_id', $newCode)->exists()) {
            $code++;
            $newCode = $prefix . '-' . $code;
        }

        // Return the unique code
        return $newCode;
    }
}


if (!function_exists('redirectWithSuccess')) {
    function redirectWithSuccess(string $message)
    {
        Session::flash('success', $message);
    }


}
if (!function_exists('redirectWithError')) {

    function redirectWithError(string $message)
    {
        Session::flash('error', $message);
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($imagePath, $defaultImage = 'images/no_image.jpg')
    {
        if (!empty($imagePath) && file_exists(public_path('storage/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }

        return asset($defaultImage);
    }
}
