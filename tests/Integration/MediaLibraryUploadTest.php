<?php

namespace Tests\Integration;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MediaLibraryUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_a_photo_generates_thumb_and_preview_conversions(): void
    {
        $event = Event::factory()->create();

        $media = $event->addMedia(UploadedFile::fake()->image('foto.jpg', 800, 600))
            ->preservingOriginal()
            ->toMediaCollection('photo');

        $this->assertFileExists($media->getPath());
        $this->assertFileExists($media->getPath('thumb'));
        $this->assertFileExists($media->getPath('preview'));
    }

    public function test_preserving_original_keeps_the_source_file_intact(): void
    {
        $event = Event::factory()->create();
        $file = UploadedFile::fake()->image('mantido.jpg');
        $source = $file->getPathname();

        $event->addMedia($file)->preservingOriginal()->toMediaCollection('photo');

        $this->assertFileExists($source);
    }

    public function test_without_preserving_original_the_source_file_is_consumed(): void
    {
        $event = Event::factory()->create();
        $file = UploadedFile::fake()->image('consumido.jpg');
        $source = $file->getPathname();

        $event->addMedia($file)->toMediaCollection('photo');

        $this->assertFileDoesNotExist($source);
    }

    public function test_cover_collection_only_ever_keeps_the_most_recent_file(): void
    {
        $event = Event::factory()->create();

        $event->addMedia(UploadedFile::fake()->image('c1.jpg'))->preservingOriginal()->toMediaCollection('cover');
        $event->addMedia(UploadedFile::fake()->image('c2.jpg'))->preservingOriginal()->toMediaCollection('cover');

        $covers = $event->fresh()->getMedia('cover');
        $this->assertCount(1, $covers);
        $this->assertSame('c2.jpg', $covers->first()->file_name);
    }

    public function test_deleting_the_model_removes_its_media_files(): void
    {
        $event = Event::factory()->create();
        $media = $event->addMedia(UploadedFile::fake()->image('apagar.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('photo');
        $path = $media->getPath();

        $event->forceDelete();

        $this->assertFileDoesNotExist($path);
    }
}
