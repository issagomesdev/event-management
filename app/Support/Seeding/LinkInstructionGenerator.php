<?php

namespace App\Support\Seeding;

/**
 * Pequenas variações do aviso exibido junto ao link de exemplo do evento.
 */
class LinkInstructionGenerator
{
    /** @var list<string> */
    private const VARIANTS = [
        'Este é um link de exemplo utilizado para demonstração do sistema.',
        'Link ilustrativo, usado apenas para fins de demonstração da plataforma.',
        'Este link é fictício e serve somente para demonstrar o funcionamento do sistema.',
        'Exemplo de link para fins de demonstração — não representa uma página real do evento.',
        'Link de demonstração: use-o apenas para testar o fluxo do sistema.',
        'Este endereço é um exemplo e foi cadastrado apenas para ilustrar a funcionalidade.',
    ];

    public function random(): string
    {
        return self::VARIANTS[array_rand(self::VARIANTS)];
    }
}
