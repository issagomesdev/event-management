<?php

namespace App\Support\Address;

class BrazilianStates
{
    /**
     * UF => nome do estado, na ordem alfabética do nome.
     *
     * @var array<string, string>
     */
    private const STATES = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];

    /**
     * @return array<string, string> UF => nome do estado
     */
    public static function all(): array
    {
        return self::STATES;
    }

    /**
     * @return list<string> lista de siglas UF válidas
     */
    public static function codes(): array
    {
        return array_keys(self::STATES);
    }

    public static function nameOf(string $uf): ?string
    {
        return self::STATES[strtoupper($uf)] ?? null;
    }
}
