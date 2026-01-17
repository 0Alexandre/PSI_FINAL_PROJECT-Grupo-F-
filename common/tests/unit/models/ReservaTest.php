<?php

namespace common\tests\unit\models;
use common\models\Reserva;

class ReservaTest extends \Codeception\Test\Unit
{
    public function testValidacaoReserva(){
        $reserva = new Reserva();

        $this->assertFalse($reserva->validate());

        $reserva->utilizador_id = 3;
        $reserva->espaco_id = 1;
        $reserva->inicio = '2026-01-10 10:00:00';
        $reserva->fim = '2026-01-10 12:00:00';
        $reserva->estado = 'ESTADO_INEXISTENTE';
        $this->assertFalse($reserva->validate(['estado']));

        $reserva->estado = 'PENDENTE';
        $this->assertTrue($reserva->validate());
    }
}