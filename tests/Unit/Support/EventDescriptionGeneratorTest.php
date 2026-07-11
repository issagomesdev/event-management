<?php

namespace Tests\Unit\Support;

use App\Support\Seeding\EventCatalog;
use App\Support\Seeding\EventDescriptionGenerator;
use PHPUnit\Framework\TestCase;

class EventDescriptionGeneratorTest extends TestCase
{
    public function test_generate_produces_between_200_and_600_words_for_every_category(): void
    {
        $generator = new EventDescriptionGenerator();

        foreach (array_keys(EventCatalog::CATEGORY_KEYWORDS) as $category) {
            $description = $generator->generate('Evento Teste', $category);
            $wordCount = count(preg_split('/\s+/u', trim($description)));

            $this->assertGreaterThanOrEqual(200, $wordCount, "Categoria {$category} gerou só {$wordCount} palavras");
            $this->assertLessThanOrEqual(600, $wordCount, "Categoria {$category} gerou {$wordCount} palavras");
        }
    }

    public function test_generate_interpolates_the_event_name(): void
    {
        $generator = new EventDescriptionGenerator();

        $description = $generator->generate('Sunset Premium', 'beach');

        $this->assertStringContainsString('Sunset Premium', $description);
    }

    public function test_generate_falls_back_to_social_for_unknown_category(): void
    {
        $generator = new EventDescriptionGenerator();

        $description = $generator->generate('Evento X', 'categoria-inexistente');

        $this->assertNotEmpty($description);
    }

    public function test_generate_never_contains_lorem_ipsum(): void
    {
        $generator = new EventDescriptionGenerator();

        $description = $generator->generate('Evento', 'corporate');

        $this->assertStringNotContainsStringIgnoringCase('lorem ipsum', $description);
    }
}
