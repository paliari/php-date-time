<?php

use Paliari\DateTime\TDate;

class TDateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group slow
     * Testa um intervalo de 15 anos se todos dias estão sendo gerados corretamente pelo TDate
     */
    public function testContructData()
    {
        $stop = date('Y', time()) + 5;
        $ano = date('Y', time()) - 10;
        $mes = 1;
        $dia = 0;

        while ($ano <= $stop) {
            $timestamp = mktime(0, 0, 0, $mes, $dia + 1, $ano);
            $dia = date('d', $timestamp);
            $mes = date('m', $timestamp);
            $ano = date('Y', $timestamp);
            $date_br = new TDate("$dia/$mes/$ano");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * @group slow
     * Testa um intervalo de 15 anos se todos dias estão sendo gerados corretamente pelo TDate
     */
    public function testContructDataUniversal()
    {
        $stop = date('Y', time()) + 5;
        $ano = date('Y', time()) - 10;
        $mes = 1;
        $dia = 0;

        while ($ano <= $stop) {
            $timestamp = mktime(0, 0, 0, $mes, $dia + 1, $ano);
            $dia = date('d', $timestamp);
            $mes = date('m', $timestamp);
            $ano = date('Y', $timestamp);
            $date_br = new TDate("$ano-$mes-$dia");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * @group slow
     * Confere se todos os segundos de um dia estão gerando o timestamp da maneira correta.
     */
    public function testContructTDate()
    {
        $ano = date('Y', time());
        $mes = date('m', time());;
        $dia = date('d', time());;
        $hora = 0;
        $min = 0;
        $sec = 0;
        $stop = $dia + 1;

        while ($dia < $stop) {
            $timestamp = mktime($hora, $min, $sec + 1, $mes, $dia, $ano);
            $dia = date('d', $timestamp);
            $mes = date('m', $timestamp);
            $ano = date('Y', $timestamp);
            $hora = date('H', $timestamp);
            $min = date('i', $timestamp);
            $sec = date('s', $timestamp);
            $date_br = new TDate("$dia/$mes/$ano $hora:$min:$sec");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * @group slow
     * Testa o construtor do TDate passando timestemp por 30 dias
     */
    public function testContructTimestamp()
    {
        $Y = date('Y', time());
        $m = date('m', time());;
        $d = 0;
        $H = 0;
        $i = 0;
        $s = 0;
        $stp = $d + 30;

        while ($d < $stp) {
            $tmstp = mktime($H, $i, $s, $m, $d + 1, $Y);
            $d = date('d', $tmstp);
            $m = date('m', $tmstp);
            $Y = date('Y', $tmstp);
            $H = date('H', $tmstp);
            $i = date('i', $tmstp);
            $s = date('s', $tmstp);

            $tDate = new TDate((int)$tmstp);
            $this->assertEquals($tmstp, $tDate->timestamp);
            $tDate = new TDate((string)$tmstp);
            $this->assertEquals($tmstp, $tDate->timestamp);
        }
    }

    /**
     * Testa se o intervalo de dias entre as duas datas estão corretos.
     */
    public function testIntervaloDias()
    {
        $this->assertEquals(30, TDate::intervaloDias(new TDate('2013-10-01'), new TDate('2013-10-31')));
        $this->assertEquals(7, TDate::intervaloDias(new TDate('2013-09-01'), new TDate('2013-08-25')));
        $this->assertEquals(30, TDate::intervaloDias(new TDate('2013-11-01'), new TDate('2013-12-1')));
    }
}
