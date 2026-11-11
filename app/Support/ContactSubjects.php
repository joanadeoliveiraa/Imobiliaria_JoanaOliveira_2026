<?php

namespace App\Support;

class ContactSubjects
{
    public const OTHER = 'Outros assuntos';
    public const RESERVATION = 'Alteração ou cancelamento de reserva';
    public const OPTIONS = [
        'Informações sobre um imóvel',
        'Disponibilidade e preços',
        'Efetuar uma reserva',
        self::RESERVATION,
        'Pagamentos e faturação',
        'Documentos e comprovativos',
        'Problemas com a minha conta',
        'Apoio durante a estadia',
        'Reclamações e sugestões',
        self::OTHER,
    ];
}
