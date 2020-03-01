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

            $response = Cloudder::upload($data->content, ['folder' => 'due-date'], $tags);
            $path     = parse_url($response->getResult()['url'])['path'];

            return [
                'path' => substr($path, strpos($path, '/', 1)),
                'name' => $response->getPublicId(),
            ];
        }

        throw new UploadException(__('exception.upload.error'));
    }
}
