<?php

namespace App\Support\Seeding;

use App\Models\Event;

/**
 * Catálogo fixo de eventos realistas usado pelos seeders. Cada entrada tem
 * nome, mês de referência, categoria (usada para gerar descrição/regras e
 * para casar a mídia certa em database/fake_media) e o tipo de vagas.
 */
class EventCatalog
{
    /**
     * Categoria => palavras-chave usadas para casar com os nomes dos
     * arquivos em database/fake_media (EventMediaSelector) e para escolher
     * os blocos de texto certos (EventDescriptionGenerator).
     *
     * @var array<string, list<string>>
     */
    public const CATEGORY_KEYWORDS = [
        'beach' => ['pool', 'beach', 'luau', 'sunset', 'resort', 'tropical'],
        'themed_party' => ['white', 'neon', 'retro', 'party', 'ballroom', 'decor', 'dancing'],
        'festa_junina' => ['junina', 'festa'],
        'halloween' => ['halloween', 'costumes'],
        'christmas' => ['christmas'],
        'new_year' => ['year', 'eve', 'celebration'],
        'music_show' => ['music', 'show', 'stage', 'concert', 'singer', 'guitarist', 'pagode', 'forro', 'forró', 'samba', 'electronic'],
        'festival' => ['festival', 'wine', 'beer', 'cultural', 'gastronomic', 'winter', 'summer'],
        'food' => ['feijoada', 'bbq', 'grilling', 'pitmaster', 'food', 'lunch', 'chefs', 'gastronomic', 'plating'],
        'corporate' => ['corporate', 'business', 'meeting', 'networking', 'tech', 'meetup', 'congress', 'expo', 'booth'],
        'social' => ['cocktails', 'rooftop', 'bartender', 'bartenders', 'happy', 'hour'],
        'celebration' => ['wedding', 'birthday', 'graduates', 'charity', 'university', 'students', 'couple'],
        'sports' => ['car', 'motorcyclists', 'volleyball', 'race', 'runners', 'antique'],
    ];

    /**
     * 36 eventos distribuídos 3 por mês ao longo do ano corrente, com
     * coerência sazonal (verão/praia no início e fim do ano, Festa Junina
     * em junho, Halloween em outubro, Réveillon em dezembro etc.).
     *
     * @return list<array{name: string, month: int, category: string, type: string}>
     */
    public static function yearly(): array
    {
        return [
            // Janeiro — verão, praia
            ['name' => 'Sunset Premium', 'month' => 1, 'category' => 'beach', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Luau na Praia', 'month' => 1, 'category' => 'beach', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'White Party', 'month' => 1, 'category' => 'themed_party', 'type' => Event::TYPE_LIMITED],

            // Fevereiro — verão, festas temáticas
            ['name' => 'Bloco da Saudade', 'month' => 2, 'category' => 'themed_party', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Pool Party Resort', 'month' => 2, 'category' => 'beach', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Noite Neon', 'month' => 2, 'category' => 'themed_party', 'type' => Event::TYPE_UNLIMITED],

            // Março — fim de verão
            ['name' => 'Sunset Rooftop Sessions', 'month' => 3, 'category' => 'beach', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Festival de Verão', 'month' => 3, 'category' => 'festival', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Cocktails no Rooftop', 'month' => 3, 'category' => 'social', 'type' => Event::TYPE_LIMITED],

            // Abril — shows, outono
            ['name' => 'Forró de Abril', 'month' => 4, 'category' => 'music_show', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Samba Show Noturno', 'month' => 4, 'category' => 'music_show', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Workshop de Tecnologia', 'month' => 4, 'category' => 'corporate', 'type' => Event::TYPE_LIMITED],

            // Maio — negócios, solidariedade
            ['name' => 'Networking Business Day', 'month' => 5, 'category' => 'corporate', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Congresso Nacional de Inovação', 'month' => 5, 'category' => 'corporate', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Feijoada Beneficente', 'month' => 5, 'category' => 'food', 'type' => Event::TYPE_LIMITED],

            // Junho — Festa Junina
            ['name' => 'Arraiá Open Bar', 'month' => 6, 'category' => 'festa_junina', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Festa Junina Tradicional', 'month' => 6, 'category' => 'festa_junina', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Noite Universitária', 'month' => 6, 'category' => 'celebration', 'type' => Event::TYPE_LIMITED],

            // Julho — férias, festivais
            ['name' => 'Festival Sertanejo', 'month' => 7, 'category' => 'music_show', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Craft Beer Fest', 'month' => 7, 'category' => 'festival', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Wine & Music Festival', 'month' => 7, 'category' => 'festival', 'type' => Event::TYPE_LIMITED],

            // Agosto — inverno, gastronomia
            ['name' => 'Winter Festival Serra', 'month' => 8, 'category' => 'festival', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Noite Gastronômica', 'month' => 8, 'category' => 'food', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Churrasco Premium', 'month' => 8, 'category' => 'food', 'type' => Event::TYPE_LIMITED],

            // Setembro — corporativo, esportes
            ['name' => 'Tech Expo Brasil', 'month' => 9, 'category' => 'corporate', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Encontro de Carros Antigos', 'month' => 9, 'category' => 'sports', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Corrida de Rua Beneficente', 'month' => 9, 'category' => 'sports', 'type' => Event::TYPE_UNLIMITED],

            // Outubro — Halloween, retrô
            ['name' => 'Halloween Experience', 'month' => 10, 'category' => 'halloween', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Noite Retrô 80s', 'month' => 10, 'category' => 'themed_party', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Motociclistas Reunidos', 'month' => 10, 'category' => 'sports', 'type' => Event::TYPE_UNLIMITED],

            // Novembro — formatura, casamentos
            ['name' => 'Baile de Formatura', 'month' => 11, 'category' => 'celebration', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Casamento no Campo', 'month' => 11, 'category' => 'celebration', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Happy Hour Corporativo', 'month' => 11, 'category' => 'social', 'type' => Event::TYPE_UNLIMITED],

            // Dezembro — Natal, Réveillon
            ['name' => 'Festa de Natal Corporativa', 'month' => 12, 'category' => 'christmas', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Réveillon Premium', 'month' => 12, 'category' => 'new_year', 'type' => Event::TYPE_LIMITED],
            ['name' => 'White Party de Fim de Ano', 'month' => 12, 'category' => 'themed_party', 'type' => Event::TYPE_UNLIMITED],
        ];
    }

    /**
     * Pool de 3 eventos exclusivo do CurrentMonthEventSeeder, sem colidir
     * com os nomes usados em yearly(). O "month" é ignorado por esse
     * seeder (ele sempre usa o mês corrente).
     *
     * @return list<array{name: string, month: int, category: string, type: string}>
     */
    public static function currentMonthPool(): array
    {
        return [
            ['name' => 'Open Bar Corporate Meetup', 'month' => 0, 'category' => 'corporate', 'type' => Event::TYPE_LIMITED],
            ['name' => 'Luau Experience', 'month' => 0, 'category' => 'beach', 'type' => Event::TYPE_UNLIMITED],
            ['name' => 'Noite Eletrônica', 'month' => 0, 'category' => 'music_show', 'type' => Event::TYPE_LIMITED],
        ];
    }

    /**
     * @return list<string>
     */
    public static function keywordsFor(string $category): array
    {
        return self::CATEGORY_KEYWORDS[$category] ?? [];
    }
}
