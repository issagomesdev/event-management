<?php

namespace App\Support\Seeding;

/**
 * Monta um regulamento coerente sorteando 6 a 10 regras de um pool
 * realista, sempre em ordem embaralhada — evita eventos com o mesmo
 * conjunto de regras.
 */
class EventRulesGenerator
{
    /** @var list<string> */
    private const RULES_POOL = [
        'É obrigatória a apresentação de documento de identificação com foto na entrada.',
        'Não é permitida a entrada com objetos cortantes ou perfurocortantes.',
        'Proibida a venda ou o consumo de bebidas alcoólicas por menores de 18 anos.',
        'Respeite os demais participantes, a equipe do evento e a equipe de segurança.',
        'A organização reserva-se o direito de recusar a entrada de pessoas em visível estado de embriaguez.',
        'Não é permitida a entrada com animais de estimação, exceto cães-guia.',
        'O uso de câmeras profissionais depende de autorização prévia da organização.',
        'É proibido fumar em áreas fechadas, conforme legislação vigente.',
        'A entrada de menores de idade desacompanhados dos responsáveis não é permitida.',
        'Itens de grande volume, como malas e mochilas grandes, poderão ser recusados na entrada.',
        'A pulseira ou ingresso de identificação deve ser mantido visível durante todo o evento.',
        'Não é permitida a entrada com alimentos e bebidas de fora do evento.',
        'A organização não se responsabiliza por objetos pessoais perdidos ou esquecidos no local.',
        'Comportamentos que coloquem em risco a segurança de outros participantes resultarão em remoção imediata.',
        'É proibida a comercialização não autorizada de produtos dentro do espaço do evento.',
        'O acesso a áreas restritas é permitido somente a convidados e equipe autorizada.',
        'Recomenda-se chegar com antecedência para evitar filas no momento do check-in.',
        'Em caso de reentrada, é necessária a validação da pulseira ou do ingresso.',
        'Fotos e vídeos podem ser feitos durante o evento para fins de divulgação da organização.',
        'A organização poderá alterar horários ou atrações por motivos de força maior, sem aviso prévio.',
        'Não é permitida a entrada com garrafas de vidro no espaço do evento.',
        'Menores de idade só têm acesso quando acompanhados de responsável legal, salvo indicação contrária.',
        'O check-in deve ser realizado somente pelo titular do convite ou por convidado previamente cadastrado.',
        'Em caso de chuva ou intempéries, a organização poderá remanejar atividades para área coberta.',
        'A saída antecipada não dá direito a reembolso de valores eventualmente pagos.',
    ];

    public function generate(int $min = 6, int $max = 10): string
    {
        $count = random_int($min, $max);
        $selected = self::RULES_POOL;
        shuffle($selected);
        $selected = array_slice($selected, 0, $count);

        $items = implode('', array_map(fn ($rule) => "<li>{$rule}</li>", $selected));

        return "<ul>{$items}</ul>";
    }
}
