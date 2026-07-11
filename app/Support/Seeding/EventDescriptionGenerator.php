<?php

namespace App\Support\Seeding;

/**
 * Monta uma descrição de 200 a 600 palavras combinando blocos de texto
 * (abertura + atrações, específicos da categoria do evento) com blocos
 * de logística e encerramento, compartilhados entre categorias. Nenhum
 * texto é lorem ipsum — tudo é escrito no tom de um evento real.
 */
class EventDescriptionGenerator
{
    /**
     * Categoria => blocos de abertura/atrações, com "%s" reservado para o
     * nome do evento.
     *
     * @var array<string, array{opening: list<string>, highlights: list<string>}>
     */
    private const BLOCKS = [
        'beach' => [
            'opening' => [
                'O %s chega para celebrar o melhor do verão à beira-mar, reunindo boa música, drinks refrescantes e aquela energia contagiante que só um pôr do sol na praia consegue proporcionar. A proposta é simples: deixar o dia a dia de lado e curtir horas de descontração ao ar livre, com os pés na areia e uma trilha sonora que não para.',
                'Com uma estrutura pensada para aproveitar o melhor cenário litorâneo, o %s promete uma tarde e noite inesquecíveis à beira-mar. Entre o som das ondas e o clima leve do verão, o evento reúne quem busca relaxar, dançar e se conectar em um ambiente descontraído e cheio de estilo.',
            ],
            'highlights' => [
                'A programação conta com DJs residentes, área lounge com vista para o mar, bar completo com drinks tropicais e espaços instagramáveis espalhados pela orla. Durante o dia, a energia é tranquila, perfeita para socializar; ao entardecer, o clima esquenta com sets ao vivo até o fim da noite.',
                'Entre as atrações, destaque para as pistas de dança montadas na areia, o cardápio assinado de coquetéis e petiscos leves, além de ativações de marcas parceiras espalhadas pelo espaço. O pôr do sol é sempre o ponto alto, acompanhado por um brinde coletivo que já virou tradição do evento.',
            ],
        ],
        'themed_party' => [
            'opening' => [
                'Prepare o look, porque o %s é sobre se jogar em uma noite temática do início ao fim. Do figurino à trilha sonora, cada detalhe foi pensado para transportar os convidados para uma atmosfera única, com produção visual caprichada e um time de curadoria musical que conhece bem o público.',
                'O %s reúne quem gosta de uma festa com identidade forte: decoração temática, iluminação especial e uma seleção musical que conversa direto com a proposta da noite. É o tipo de evento em que vale caprichar na produção para aproveitar cada momento.',
            ],
            'highlights' => [
                'A pista principal recebe DJs convidados durante toda a madrugada, intercalando sets temáticos com clássicos que garantem a plateia sempre dançando. Um camarote lounge oferece uma opção mais tranquila para quem quer descansar entre uma música e outra, sem perder o clima da festa.',
                'Além da pista de dança, o evento conta com fotógrafos profissionais circulando para registrar os melhores looks, cantos temáticos para fotos e um bar completo com coquetéis exclusivos criados especialmente para a ocasião.',
            ],
        ],
        'festa_junina' => [
            'opening' => [
                'Chegou a hora do %s, uma verdadeira celebração das tradições juninas com quadrilha, fogueira, comidas típicas e muito forró pé de serra. O evento resgata o clima interiorano em plena cidade, com direito a bandeirinhas coloridas e decoração caprichada.',
                'O %s é a festa perfeita para quem ama as tradições de São João: milho verde, quentão, roupas xadrez e uma pista de dança animada ao som de sanfona, zabumba e triângulo. Um arraiá completo, pensado para toda a família.',
            ],
            'highlights' => [
                'Entre as atrações estão a apresentação de quadrilha junina, barracas típicas com pamonha, canjica, cachorro-quente e quentão, além de shows ao vivo com bandas de forró. Brincadeiras tradicionais como pescaria e correio elegante completam a programação.',
                'A programação inclui fogueira simbólica, sorteio de prêmios, comidas típicas servidas em barracas temáticas e apresentações musicais que vão do forró raiz ao forró eletrônico, garantindo diversão para todas as idades.',
            ],
        ],
        'halloween' => [
            'opening' => [
                'O %s transforma o espaço em um cenário digno das noites mais assombradas do ano, com decoração temática, iluminação especial e uma trilha sonora que cria clima do início ao fim. Fantasias são super bem-vindas — e incentivadas.',
                'Prepare-se para uma noite de sustos e diversão no %s. Com cenografia elaborada, personagens circulando pelo evento e uma seleção musical envolvente, a proposta é criar uma experiência imersiva para quem topar entrar no clima do Halloween.',
            ],
            'highlights' => [
                'Entre as atrações estão o concurso de melhor fantasia, casa assombrada temática, DJs convidados e um bar com drinks especiais criados para a data. Fotógrafos circulam pelo evento registrando os looks mais criativos da noite.',
                'A programação reserva espaços temáticos para fotos, atores caracterizados interagindo com o público e uma pista de dança que recebe sets especiais inspirados no clima de terror e suspense da noite.',
            ],
        ],
        'christmas' => [
            'opening' => [
                'O %s celebra o espírito natalino com uma confraternização especial, reunindo colegas, parceiros e convidados para fechar o ano em grande estilo, em um ambiente decorado e acolhedor.',
                'Para celebrar o fim de ano, o %s promete uma noite de confraternização com decoração natalina, boa mesa e momentos para reconhecer conquistas e fortalecer relações ao longo do ano.',
            ],
            'highlights' => [
                'A programação inclui jantar especial, distribuição de brindes, sorteios e um momento de celebração coletiva, além de ambientação temática com direito a árvore de Natal e iluminação especial.',
                'Entre as atrações está uma apresentação musical natalina, mesa de doces e petiscos especiais, e uma dinâmica de confraternização pensada para aproximar todos os presentes antes do encerramento do ano.',
            ],
        ],
        'new_year' => [
            'opening' => [
                'O %s é a virada perfeita para quem quer começar o ano novo com estilo, reunindo boa música, open bar completo e uma queima de fogos para marcar a passagem de ano em grande estilo.',
                'Para fechar o ano com chave de ouro, o %s reúne uma produção especial de Réveillon, com decoração sofisticada, DJs convidados e contagem regressiva coletiva até a meia-noite.',
            ],
            'highlights' => [
                'A festa conta com open bar premium, ceia especial de Réveillon, show de fogos de artifício à meia-noite e uma pista de dança que não para até o amanhecer do novo ano.',
                'Entre as atrações, destaque para o brinde coletivo à meia-noite, distribuição de itens simbólicos da virada e uma seleção musical que passeia por diferentes estilos ao longo da madrugada.',
            ],
        ],
        'music_show' => [
            'opening' => [
                'O %s traz um show ao vivo imperdível, com uma produção de som e luz à altura do repertório e um palco pensado para valorizar cada momento da apresentação.',
                'Prepare a voz, porque o %s promete uma noite de muita música ao vivo, com um repertório que passeia por clássicos e sucessos mais recentes, direto do palco para o público.',
            ],
            'highlights' => [
                'A programação inclui abertura com banda convidada, show principal com repertório completo e uma área VIP com vista privilegiada para o palco. A estrutura de som foi pensada para garantir a melhor experiência em todos os setores.',
                'Entre os destaques estão os solos instrumentais, a interação constante da banda com a plateia e um encerramento especial com participações surpresa, que costuma arrancar aplausos até o último acorde.',
            ],
        ],
        'festival' => [
            'opening' => [
                'O %s reúne em um só lugar diferentes atrações, expositores e experiências, criando um roteiro completo para quem quer aproveitar o dia inteiro sem pressa.',
                'Com uma curadoria cuidadosa de atrações, o %s propõe um festival completo, ideal para quem gosta de circular entre estandes, provar novidades e aproveitar apresentações ao vivo ao longo do dia.',
            ],
            'highlights' => [
                'A programação reúne expositores selecionados, apresentações culturais, área gastronômica variada e espaços de descanso espalhados pelo evento, garantindo conforto para aproveitar cada atração com calma.',
                'Entre as atrações estão oficinas temáticas, degustações guiadas, apresentações ao vivo em palco próprio e uma feira de expositores locais, reunindo o melhor da produção regional em um único lugar.',
            ],
        ],
        'food' => [
            'opening' => [
                'O %s é um convite para os amantes da boa gastronomia, reunindo pratos cuidadosamente preparados, harmonizações especiais e um ambiente pensado para aproveitar cada detalhe da experiência à mesa.',
                'Com um cardápio especialmente desenvolvido para a ocasião, o %s celebra sabores marcantes da culinária brasileira em um ambiente acolhedor, ideal para reunir amigos, família ou colegas em torno da boa mesa.',
            ],
            'highlights' => [
                'A programação inclui estações de comida ao vivo, chefs preparando pratos na hora e uma seleção de bebidas harmonizadas especialmente para o cardápio do dia. Mesas comunitárias favorecem a socialização entre os convidados.',
                'Entre os destaques estão as porções para compartilhar, sobremesas assinadas e um espaço dedicado à preparação ao vivo, permitindo acompanhar de perto o preparo de cada prato servido durante o evento.',
            ],
        ],
        'corporate' => [
            'opening' => [
                'O %s reúne profissionais, empreendedores e lideranças para um momento de troca de experiências, apresentação de novidades do setor e construção de conexões relevantes para os negócios.',
                'Pensado para gerar conexões reais, o %s propõe um ambiente estruturado para networking qualificado, com painéis, apresentações e espaços dedicados a conversas de negócios.',
            ],
            'highlights' => [
                'A programação inclui painéis com especialistas convidados, espaço de networking estruturado, estandes de expositores e um coffee break pensado para estimular novas conversas entre os participantes.',
                'Entre as atrações estão apresentações de cases de sucesso, rodadas de negócios e um momento de perguntas e respostas com os palestrantes, encerrando com um coquetel de confraternização.',
            ],
        ],
        'social' => [
            'opening' => [
                'O %s é o encontro perfeito para descontrair depois de um dia cheio, reunindo boa conversa, drinks bem preparados e uma vista privilegiada em um ambiente descontraído.',
                'Pensado para relaxar em boa companhia, o %s reúne colegas e amigos em um ambiente acolhedor, com carta de drinks especial e uma trilha sonora que acompanha o clima da noite sem atropelar as conversas.',
            ],
            'highlights' => [
                'A programação inclui carta de coquetéis autorais preparados por bartenders especializados, petiscos para compartilhar e um DJ set ambiente que cresce em intensidade ao longo da noite.',
                'Entre os destaques estão a happy hour com preços especiais nas primeiras horas, um cantinho lounge para conversas mais tranquilas e um mix musical que equilibra clássicos e novidades.',
            ],
        ],
        'celebration' => [
            'opening' => [
                'O %s é uma celebração especial, preparada nos mínimos detalhes para tornar a ocasião ainda mais marcante para quem participa, com uma ambientação cuidadosa e uma programação emocionante.',
                'Reunindo familiares, amigos e convidados especiais, o %s celebra um momento único com toda a produção e o carinho que a ocasião merece.',
            ],
            'highlights' => [
                'A programação inclui cerimônia especial, decoração personalizada, mesa de doces e um repertório musical escolhido a dedo para acompanhar cada momento da celebração.',
                'Entre os destaques estão o brinde coletivo, registros fotográficos profissionais e uma pista de dança que garante a festa animada até o fim da noite.',
            ],
        ],
        'sports' => [
            'opening' => [
                'O %s reúne apaixonados por um estilo de vida mais ativo, com uma programação pensada para quem gosta de compartilhar essa paixão em boa companhia.',
                'Com uma organização cuidadosa de percurso e segurança, o %s promete um encontro e tanto para quem gosta de esporte, adrenalina e boa energia em grupo.',
            ],
            'highlights' => [
                'A programação inclui concentração antes da largada, percurso sinalizado, pontos de apoio ao longo do trajeto e uma confraternização especial para celebrar ao final do evento.',
                'Entre os destaques estão a exposição de veículos e equipamentos, premiação simbólica para os participantes e um encontro social ao final, reunindo todos para compartilhar histórias do dia.',
            ],
        ],
    ];

    /** @var list<string> */
    private const LOGISTICS = [
        'A organização recomenda chegar com antecedência para agilizar o check-in na entrada, evitando filas no início da programação. A equipe de recepção estará disponível para orientar os convidados assim que o portão abrir.',
        'O check-in é feito de forma rápida na entrada, mediante confirmação de presença. A estrutura conta com equipe de apoio, sinalização clara e pontos de atendimento espalhados pelo espaço para garantir conforto durante todo o evento.',
        'Para uma experiência tranquila, a organização sugere confirmar presença com antecedência e chegar próximo ao horário de abertura. Toda a estrutura foi planejada para receber bem os convidados, com equipe treinada e pontos de apoio bem sinalizados.',
    ];

    /** @var list<string> */
    private const CLOSING = [
        'Reserve a data, chame quem você gosta e venha viver essa experiência de perto — vai valer cada minuto.',
        'É um daqueles eventos para marcar na agenda e não perder por nada. Garanta sua presença e venha conferir de perto.',
        'Uma programação pensada para ficar na memória. Confirme presença e prepare-se para aproveitar cada momento ao lado de boa companhia.',
    ];

    public function generate(string $eventName, string $category): string
    {
        $blocks = self::BLOCKS[$category] ?? self::BLOCKS['social'];

        $paragraphs = [
            sprintf($this->pick($blocks['opening']), $eventName),
            $this->pick($blocks['highlights']),
            $this->pick(self::LOGISTICS),
            $this->pick(self::CLOSING),
        ];

        $safety = 0;
        while ($this->wordCount($paragraphs) < 200 && $safety < 5) {
            $paragraphs[] = $this->pick($blocks['highlights']);
            $safety++;
        }

        return implode("\n\n", $paragraphs);
    }

    /**
     * @param list<string> $variants
     */
    private function pick(array $variants): string
    {
        return $variants[array_rand($variants)];
    }

    /**
     * @param list<string> $paragraphs
     */
    private function wordCount(array $paragraphs): int
    {
        return count(preg_split('/\s+/u', trim(implode(' ', $paragraphs))));
    }
}
