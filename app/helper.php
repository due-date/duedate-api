<?php

use Illuminate\Support\Fluent;
use JD\Cloudder\Facades\Cloudder;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

if (!function_exists('uploadFile')) {
    function uploadFile(array $attributes, array $tags = [])
    {
        $data = new Fluent($attributes);

        if (is_null($data->content)) {
            return [];
        }

        if (preg_match('/^data:(\w+)\/(\w+);base64,/', $data->content)) {
            $publicId = time();
            $response = Cloudder::upload($data->content, 'due-date/customers/' . $publicId, $tags);
            $path     = parse_url($response->getResult()['url'])['path'];

            return [
                'path' => substr($path, strpos($path, '/', 1)),
                'name' => $response->getPublicId(),
            ];
        }

        throw new UploadException(__('exception.upload.error'));
    }
}
