<?php

if (! function_exists('s3_url')) {
    /**
     * Generate asset link for S3
     *
     * @param string $file
     * @return string
     */
    function s3_url($file) {
        $baseUrl = config('services.transcoder.url');

        return $baseUrl . '/' . $file;
    }
}
