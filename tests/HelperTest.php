<?php

namespace Tests;

use JD\Cloudder\CloudinaryWrapper;
use JD\Cloudder\Facades\Cloudder;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Tests\Fixtures\PhotoFixture;

class HelperTest extends TestCase
{

    /**
     * @test
     */
    public function shouldUploadedFile()
    {
        $cloudinaryWrapper = \Mockery::mock(CloudinaryWrapper::class);
        $cloudinaryWrapper->shouldReceive('getResult')->once()->andReturn(['url' => 'http://url.com.br/path_one/path_two/image_name.png']);
        $cloudinaryWrapper->shouldReceive('getPublicId')->once()->andReturn('image_name');

        $content = PhotoFixture::photo();

        Cloudder::shouldReceive('upload')->once()->andReturn($cloudinaryWrapper);

        $file = uploadFile(['content' => $content]);

        $this->assertEquals('/path_two/image_name.png', $file['path']);
        $this->assertEquals('image_name', $file['name']);
    }

    /**
     * @test
     */
    public function notShouldUploadedFile()
    {
        $this->expectException(UploadException::class);
        $this->expectExceptionMessage('Error importing the file, try uploading a new file');

        uploadFile(['content' => 'bm9tZSxlLWhaWwsY3BmCm']);
    }
}
