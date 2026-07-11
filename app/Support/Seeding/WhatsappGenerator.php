<?php

namespace App\Support\Seeding;

/**
 * Gera números de WhatsApp brasileiros plausíveis (DDDs reais) e variações
 * de mensagem padrão para o evento e para o canal de ajuda.
 */
class WhatsappGenerator
{
    /** @var list<int> DDDs reais em uso no Brasil */
    private const DDDS = [
        11, 21, 27, 31, 41, 47, 48, 51, 61, 62, 71, 81, 82, 83, 85, 91, 92, 98,
    ];

    /** @var list<string> */
    private const EVENT_MESSAGE_VARIANTS = [
        'Olá! Gostaria de obter mais informações sobre o evento.',
        'Oi! Poderia me passar mais detalhes sobre esse evento?',
        'Olá, tudo bem? Tenho interesse em participar e queria saber mais.',
        'Oi! Vi o evento por aqui e queria confirmar alguns detalhes.',
        'Olá! Ainda há vagas disponíveis? Gostaria de mais informações.',
    ];

    public function number(): string
    {
        $ddd = self::DDDS[array_rand(self::DDDS)];
        $prefix = random_int(90000, 99999);
        $suffix = random_int(1000, 9999);

        return sprintf('(%02d) %d-%d', $ddd, $prefix, $suffix);
    }

    public function eventMessage(): string
    {
        return self::EVENT_MESSAGE_VARIANTS[array_rand(self::EVENT_MESSAGE_VARIANTS)];
    }
}
