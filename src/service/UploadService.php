<?php
namespace Maxitsa\Service;

class UploadService
{
    public static function upload($file, $destination)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            if (!is_dir($destination)) {
                if (!mkdir($destination, 0777, true)) {
                    throw new \Exception("Impossible de créer le dossier d'upload.");
                }
            }
            if (!is_writable($destination)) {
                throw new \Exception("Le dossier d'upload n'est pas accessible en écriture.");
            }
            $tmpName = $file['tmp_name'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid('img_', true);
            if ($ext) {
                $uniqueName .= '.' . $ext;
            }
            $uploadPath = rtrim($destination, '/') . '/' . $uniqueName;
            if (move_uploaded_file($tmpName, $uploadPath)) {
                return $uploadPath;
            } else {
                $errorMsg = "Failed to move uploaded file.\n";
                $errorMsg .= "tmp_name: $tmpName\n";
                $errorMsg .= "uploadPath: $uploadPath\n";
                $errorMsg .= "is_writable(dest): ".(is_writable($destination)?'yes':'no')."\n";
                $errorMsg .= "file_exists(tmp): ".(file_exists($tmpName)?'yes':'no')."\n";
                error_log($errorMsg);
                throw new \Exception($errorMsg);
            }
        } else {
            throw new \Exception("File upload error: " . $file['error']);
        }
    }
}
