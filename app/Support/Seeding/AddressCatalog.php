<?php

namespace App\Support\Seeding;

/**
 * Endereços brasileiros reais fixos (sem depender de rede em tempo de
 * seed) — cobrem várias cidades para dar variedade aos eventos.
 */
class AddressCatalog
{
    /**
     * @var list<array{cep: string, state: string, city: string, neighborhood: string, street: string}>
     */
    private const ADDRESSES = [
        ['cep' => '50030-230', 'state' => 'PE', 'city' => 'Recife', 'neighborhood' => 'Boa Vista', 'street' => 'Avenida Conde da Boa Vista'],
        ['cep' => '53020-100', 'state' => 'PE', 'city' => 'Olinda', 'neighborhood' => 'Carmo', 'street' => 'Rua do Amparo'],
        ['cep' => '01310-100', 'state' => 'SP', 'city' => 'São Paulo', 'neighborhood' => 'Bela Vista', 'street' => 'Avenida Paulista'],
        ['cep' => '04538-133', 'state' => 'SP', 'city' => 'São Paulo', 'neighborhood' => 'Itaim Bibi', 'street' => 'Avenida Brigadeiro Faria Lima'],
        ['cep' => '22070-011', 'state' => 'RJ', 'city' => 'Rio de Janeiro', 'neighborhood' => 'Copacabana', 'street' => 'Avenida Atlântica'],
        ['cep' => '22440-032', 'state' => 'RJ', 'city' => 'Rio de Janeiro', 'neighborhood' => 'Leblon', 'street' => 'Avenida Ataulfo de Paiva'],
        ['cep' => '30130-110', 'state' => 'MG', 'city' => 'Belo Horizonte', 'neighborhood' => 'Savassi', 'street' => 'Rua Pium-í'],
        ['cep' => '40140-110', 'state' => 'BA', 'city' => 'Salvador', 'neighborhood' => 'Barra', 'street' => 'Avenida Oceânica'],
        ['cep' => '80010-000', 'state' => 'PR', 'city' => 'Curitiba', 'neighborhood' => 'Centro', 'street' => 'Rua XV de Novembro'],
        ['cep' => '90010-150', 'state' => 'RS', 'city' => 'Porto Alegre', 'neighborhood' => 'Centro Histórico', 'street' => 'Avenida Borges de Medeiros'],
        ['cep' => '60165-121', 'state' => 'CE', 'city' => 'Fortaleza', 'neighborhood' => 'Meireles', 'street' => 'Avenida Beira Mar'],
        ['cep' => '57035-190', 'state' => 'AL', 'city' => 'Maceió', 'neighborhood' => 'Ponta Verde', 'street' => 'Avenida Doutor Antônio Gouveia'],
        ['cep' => '58045-000', 'state' => 'PB', 'city' => 'João Pessoa', 'neighborhood' => 'Cabo Branco', 'street' => 'Avenida Rui Carneiro'],
        ['cep' => '70040-010', 'state' => 'DF', 'city' => 'Brasília', 'neighborhood' => 'Asa Sul', 'street' => 'SCLS 104'],
        ['cep' => '88010-400', 'state' => 'SC', 'city' => 'Florianópolis', 'neighborhood' => 'Centro', 'street' => 'Avenida Beira Mar Norte'],
        ['cep' => '69020-030', 'state' => 'AM', 'city' => 'Manaus', 'neighborhood' => 'Adrianópolis', 'street' => 'Avenida Djalma Batista'],
        ['cep' => '66055-090', 'state' => 'PA', 'city' => 'Belém', 'neighborhood' => 'Umarizal', 'street' => 'Avenida Visconde de Souza Franco'],
        ['cep' => '29050-545', 'state' => 'ES', 'city' => 'Vitória', 'neighborhood' => 'Praia do Canto', 'street' => 'Avenida Nossa Senhora da Penha'],
        ['cep' => '78048-800', 'state' => 'MT', 'city' => 'Cuiabá', 'neighborhood' => 'Centro Norte', 'street' => 'Avenida Miguel Sutil'],
        ['cep' => '74015-100', 'state' => 'GO', 'city' => 'Goiânia', 'neighborhood' => 'Setor Central', 'street' => 'Avenida Goiás'],
    ];

    /**
     * @return array{cep: string, state: string, city: string, neighborhood: string, street: string, number: string}
     */
    public function random(): array
    {
        $address = self::ADDRESSES[array_rand(self::ADDRESSES)];
        $address['number'] = (string) random_int(10, 2500);

        return $address;
    }
}
