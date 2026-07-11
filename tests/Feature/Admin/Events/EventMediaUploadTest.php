<?php

namespace Tests\Feature\Admin\Events;

use App\Models\Event;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class EventMediaUploadTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_store_media_accepts_a_valid_image_and_returns_its_generated_name(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.events.storeMedia'), [
            'file' => UploadedFile::fake()->image('foto.jpg', 200, 200),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['name', 'original_name']);
        $this->assertSame('foto.jpg', $response->json('original_name'));
    }

    public function test_store_media_requires_authentication(): void
    {
        $response = $this->post(route('admin.events.storeMedia'), [
            'file' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_store_media_rejects_a_file_over_the_given_size_limit(): void
    {
        $this->actingAsAdmin();

        // MediaUploadingTrait calcula o limite como `size * 1024` KB — ou
        // seja, "size" na prática se comporta como MB, não KB. Com size=1
        // o limite efetivo vira 1024 KB (1MB); um arquivo de 2MB estoura.
        $response = $this->postJson(route('admin.events.storeMedia'), [
            'file' => UploadedFile::fake()->create('grande.jpg', 2000),
            'size' => 1,
        ]);

        $response->assertJsonValidationErrors('file');
    }

    public function test_store_media_rejects_dimensions_above_the_given_limit(): void
    {
        $this->actingAsAdmin();

        $response = $this->postJson(route('admin.events.storeMedia'), [
            'file' => UploadedFile::fake()->image('grande.jpg', 500, 500),
            'width' => 100,
            'height' => 100,
        ]);

        $response->assertJsonValidationErrors('file');
    }

    public function test_creating_an_event_with_photos_and_a_cover_attaches_them_to_the_right_collections(): void
    {
        $this->actingAsAdmin();

        $photo = $this->post(route('admin.events.storeMedia'), ['file' => UploadedFile::fake()->image('p1.jpg')])->json('name');
        $cover = $this->post(route('admin.events.storeMedia'), ['file' => UploadedFile::fake()->image('c1.jpg')])->json('name');

        $response = $this->post(route('admin.events.store'), [
            'name' => 'Evento Com Fotos',
            'visualization' => '1',
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => '1',
            'photo' => [$photo],
            'cover' => $cover,
        ]);

        $response->assertRedirect(route('admin.events.index'));
        $event = Event::where('name', 'Evento Com Fotos')->firstOrFail();
        $this->assertCount(1, $event->getMedia('photo'));
        $this->assertCount(1, $event->getMedia('cover'));
    }

    public function test_replacing_the_cover_on_update_removes_the_previous_one(): void
    {
        $this->actingAsAdmin();
        $event = Event::factory()->create();
        $firstCoverName = $this->post(route('admin.events.storeMedia'), ['file' => UploadedFile::fake()->image('c1.jpg')])->json('name');
        $event->addMedia(storage_path('tmp/uploads/' . $firstCoverName))->toMediaCollection('cover');

        $secondCoverName = $this->post(route('admin.events.storeMedia'), ['file' => UploadedFile::fake()->image('c2.jpg')])->json('name');

        $this->put(route('admin.events.update', $event), [
            'name' => $event->name,
            'visualization' => '1',
            'type' => Event::TYPE_UNLIMITED,
            'allow_guests' => '1',
            'cover' => $secondCoverName,
        ])->assertRedirect(route('admin.events.index'));

        $this->assertCount(1, $event->fresh()->getMedia('cover'));
    }
}
