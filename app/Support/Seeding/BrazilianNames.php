<?php

namespace App\Support\Seeding;

/**
 * Pools de nomes e sobrenomes brasileiros comuns, usados tanto para
 * clientes quanto para convidados — evita nomes genéricos de Faker.
 */
class BrazilianNames
{
    /** @var list<string> */
    private const FIRST_NAMES = [
        'João Pedro', 'Maria Eduarda', 'Carlos Henrique', 'Ana Clara',
        'Gabriel', 'Beatriz', 'Lucas', 'Larissa', 'Pedro Henrique',
        'Isabela', 'Rafael', 'Camila', 'Matheus', 'Juliana', 'Guilherme',
        'Fernanda', 'Bruno', 'Amanda', 'Felipe', 'Letícia', 'Thiago',
        'Mariana', 'Diego', 'Carolina', 'Rodrigo', 'Bianca', 'Vinícius',
        'Débora', 'Leonardo', 'Patrícia', 'André', 'Vanessa', 'Marcelo',
        'Priscila', 'Eduardo', 'Renata', 'Gustavo', 'Aline', 'Daniel',
        'Natália', 'Fábio', 'Tatiane', 'Ricardo', 'Michele', 'Alexandre',
        'Simone', 'Marcos', 'Cristina', 'Paulo', 'Vitória',
    ];

    /** @var list<string> */
    private const SURNAMES = [
        'Silva', 'Souza', 'Oliveira', 'Santos', 'Pereira', 'Costa',
        'Rodrigues', 'Almeida', 'Nascimento', 'Lima', 'Araújo', 'Fernandes',
        'Carvalho', 'Gomes', 'Martins', 'Rocha', 'Ribeiro', 'Alves',
        'Monteiro', 'Cardoso', 'Teixeira', 'Moreira', 'Correia', 'Barbosa',
        'Melo', 'Freitas', 'Barros', 'Pinto', 'Vieira', 'Cavalcanti',
    ];

    public static function firstName(): string
    {
        return self::FIRST_NAMES[array_rand(self::FIRST_NAMES)];
    }

    public static function surname(): string
    {
        return self::SURNAMES[array_rand(self::SURNAMES)];
    }

    public static function fullName(): string
    {
        return self::firstName().' '.self::surname();
    }
}
