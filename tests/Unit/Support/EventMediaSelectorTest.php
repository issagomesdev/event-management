<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\EventMediaSelector;
use Tests\TestCase;

class EventMediaSelectorTest extends TestCase
{
    public function test_pick_photos_returns_the_requested_amount(): void
    {
        $selector = new EventMediaSelector();

        $photos = $selector->pickPhotos(['beach', 'pool'], 4);

        $this->assertCount(4, $photos);
        foreach ($photos as $photo) {
            $this->assertFileExists($photo);
        }
    }

    public function test_pick_photos_never_exceeds_the_available_catalog_size(): void
    {
        $selector = new EventMediaSelector();

        $photos = $selector->pickPhotos(['halloween'], 10000);

        $this->assertGreaterThan(0, count($photos));
        $this->assertLessThanOrEqual(count(glob(database_path('fake_media') . '/*')), count($photos));
    }

    public function test_pick_cover_returns_the_first_selected_photo(): void
    {
        $selector = new EventMediaSelector();
        $photos = $selector->pickPhotos(['festival'], 3);

        $this->assertSame($photos[0], $selector->pickCover($photos));
    }
}
