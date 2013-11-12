<?php

use Paliari\DateTime\TDateTime;

class TDateTimeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var TDateTime
     */
    public $date;

    public function __construct()
    {
        $this->date = new TDateTime('2013-05-01');
    }

    /**
     * @group slow
     * Testa um intervalo de 15 anos se todos dias estão sendo gerados corretamente pelo DateBr
     */
    public function testContructDataUniversal()
    {
        $stop = date('Y', time()) + 5;
        $ano  = date('Y', time()) - 10;
        $mes  = 1;
        $dia  = 0;

        while ($ano <= $stop) {
            $timestamp = mktime(0, 0, 0, $mes, $dia + 1, $ano);
            $dia       = date('d', $timestamp);
            $mes       = date('m', $timestamp);
            $ano       = date('Y', $timestamp);
            $date_br   = new TDateTime("$ano-$mes-$dia");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * @group slow
     * Testa o construtor do DateBr passando timestemp por 30 dias
     */
    public function testContructTimestamp()
    {
        $Y = date('Y', time());
        $m = date('m', time());;
        $d   = 0;
        $H   = 0;
        $i   = 0;
        $s   = 0;
        $stp = $d + 30;

        while ($d < $stp) {
            $tmstp = mktime($H, $i, $s, $m, $d + 1, $Y);
            $d     = date('d', $tmstp);
            $m     = date('m', $tmstp);
            $Y     = date('Y', $tmstp);
            $H     = date('H', $tmstp);
            $i     = date('i', $tmstp);
            $s     = date('s', $tmstp);

            $dateBr = new TDateTime((int)$tmstp);
            $this->assertEquals($tmstp, $dateBr->timestamp);
            $dateBr = new TDateTime((string)$tmstp);
            $this->assertEquals($tmstp, $dateBr->timestamp);
        }
    }

    /**
     * Verifica se a difereca de dias entre as duas datas retornadas pela funcao esta correta
     */
    public function testIntervaloDias()
    {

        $this->assertEquals(30, TDateTime::intervalDays(new TDateTime('2013-10-01'), new TDateTime('2013-10-31')));
        $this->assertEquals(-7, TDateTime::intervalDays(new TDateTime('2013-09-01'), new TDateTime('2013-08-25')));
        $this->assertEquals(30, TDateTime::intervalDays(new TDateTime('2013-11-01'), new TDateTime('2013-12-1')));
    }

    /**
     * Verifica o retorno de compareDate.
     */
    public function testCompareDate()
    {
        $date = new TDateTime('2013-10-01');
        $this->assertEquals(-1, $date->compareDate(new TDateTime('2013-09-25')));
        $this->assertEquals(0, $date->compareDate(new TDateTime('2013-10-01')));
        $this->assertEquals(1, $date->compareDate(new TDateTime('2013-10-25')));
    }

    /**
     * Verifica se o create date está funcionando normalmente
     */
    public function testCreateDate()
    {
        $this->assertEquals(Date('Y-m-d H:i:s', time()), TDateTime::createDate('now'));
        $this->assertEquals('2013-11-07 00:00:00', TDateTime::createDate('2013-11-07')->dateTimeToString());
    }

    /**
     * Verifica se a funcao retorna null ou nao de acordo com o parametro passado
     */
    public function testNull()
    {
        $this->assertNull(TDateTime::createDate());
        $this->assertNotNull(TDateTime::createDate('now'));
    }

    /**
     * Verifica se parametro errado gera excecao
     * @expectedException DomainException
     */
    public function testException()
    {
        TDateTime::createDate('nogsgsw');
    }

    public function testAddYear()
    {
        $this->assertEquals('2015-05-01', $this->date->addYears(2)->toDateString());
    }

    public function testSubYear()
    {
        $this->assertEquals('2011-05-01', $this->date->subYears(2)->toDateString());
    }

    public function testAddMonths()
    {
        $this->assertEquals('2013-07-01', $this->date->addMonths(2)->toDateString());
    }

    public function testSubMonth()
    {
        $this->assertEquals('2013-03-01', $this->date->subMonths(2)->toDateString());
    }

    public function testAddDays()
    {
        $this->assertEquals('2013-05-03', $this->date->addDays(2)->toDateString());
    }

    public function testSubDays()
    {
        $this->assertEquals('2013-04-29',$this->date->subDays(2)->toDateString());
    }

    public function testAddHour()
    {
        $this->assertEquals('2013-05-01 02:00:00', $this->date->addHours(2)->toDateTimeString());
}

    public function testSubHour()
    {
        $this->assertEquals('2013-04-30 22:00:00', $this->date->subHours(2)->toDateTimeString());
    }

    public function testAddMinute()
    {
        $this->assertEquals('2013-05-01 00:02:00', $this->date->addMinutes(2)->toDateTimeString());
    }

    public function testSubMinute()
    {
        $this->assertEquals('2013-04-30 23:58:00', $this->date->subMinutes(2)->toDateTimeString());
    }

    public function testAddSecond()
    {
        $this->assertEquals('2013-05-01 00:00:02', $this->date->addSeconds(2)->toDateTimeString());
    }

    public function testSubSecond()
    {
        $this->assertEquals('2013-04-30 23:59:58', $this->date->subSeconds(2)->toDateTimeString());
    }
}
