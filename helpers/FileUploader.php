<?php
// helpers/FileUploader.php

class FileUploader {
    private $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
    private $maxSize = 5242880; // 5MB
    private $uploadDir;

    public function __construct($subDir = 'posts') {
        $this->uploadDir = UPLOAD_DIR . '/' . $subDir . '/';
        
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function upload($file) {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new Exception('Invalid file parameters.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('Exceeded filesize limit.');
            default:
                throw new Exception('Unknown errors.');
        }

        if ($file['size'] > $this->maxSize) {
            throw new Exception('Exceeded filesize limit (5MB).');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!in_array($mime, $this->allowedMimes, true)) {
            throw new Exception('Invalid file format. Allowed: JPEG, PNG, WebP.');
        }

        $ext = array_search($mime, array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
        ), true);

        if ($ext === false) {
            throw new Exception('Invalid file extension.');
        }

        $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
        $filepath = $this->uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception('Failed to move uploaded file.');
        }

        return $filename;
    }
}
