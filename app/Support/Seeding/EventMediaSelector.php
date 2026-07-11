<?php

namespace App\Support\Seeding;

use Illuminate\Support\Facades\File;

/**
 * Seleciona, sem repetir varreduras em disco, fotos de database/fake_media
 * que combinam semanticamente com a categoria de um evento.
 */
class EventMediaSelector
{
    /** @var array<int, array{path: string, words: array<string, true>}>|null */
    private static ?array $catalog = null;

    /**
     * @param list<string> $keywords palavras-chave (minúsculas) da categoria do evento
     * @return list<string> caminhos absolutos das imagens escolhidas
     */
    public function pickPhotos(array $keywords, int $count): array
    {
        $catalog = $this->catalog();
        $count = max(1, min($count, count($catalog)));

        $scored = [];
        foreach ($catalog as $index => $entry) {
            $scored[$index] = count(array_intersect($keywords, array_keys($entry['words'])));
        }

        $indexes = array_keys($catalog);
        shuffle($indexes);
        usort($indexes, fn ($a, $b) => $scored[$b] <=> $scored[$a]);

        $chosen = array_slice($indexes, 0, $count);

        return array_map(fn ($index) => $catalog[$index]['path'], $chosen);
    }

    /**
     * @param list<string> $photos caminhos já escolhidos para o evento (via pickPhotos)
     */
    public function pickCover(array $photos): string
    {
        return $photos[0];
    }

    /**
     * @return array<int, array{path: string, words: array<string, true>}>
     */
    private function catalog(): array
    {
        if (self::$catalog !== null) {
            return self::$catalog;
        }

        $files = File::files(database_path('fake_media'));

        self::$catalog = array_values(array_map(function ($file) {
            $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $words = preg_split('/[^a-zA-Z]+/', $name) ?: [];
            $words = array_filter(array_map('strtolower', $words), fn ($word) => $word !== '');

            return [
                'path' => $file->getPathname(),
                'words' => array_fill_keys($words, true),
            ];
        }, $files));

        return self::$catalog;
    }
}
