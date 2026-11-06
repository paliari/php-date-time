<?php
use Paliari\DateTime\TDate;
use PHPUnit\Framework\Attributes\Group;

class TDateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Testa de 2010 a 2030 se todos dias estão sendo gerados corretamente pelo TDate
     */
    #[Group('slow')]
    public function testContructDataUniversal()
    {
        $stop = 2030;
        $ano  = 2010;
        $mes  = 1;
        $dia  = 0;
        while ($ano <= $stop) {
            $timestamp = mktime(0, 0, 0, $mes, $dia + 1, $ano);
            $dia       = date('d', $timestamp);
            $mes       = date('m', $timestamp);
            $ano       = date('Y', $timestamp);
            $date_br   = new TDate("$ano-$mes-$dia");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * Testa o construtor do TDate passando timestemp por 30 dias
     */
    #[Group('slow')]
    public function testContructTimestamp()
    {
        $Y = 2013;
        $m = 1;
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
        $date = new TDate('2013-10-01');
        $this->assertSame(30, $date->intervalDays(new TDate('2013-10-31')));
        $date = new TDate('2013-09-01');
        $this->assertSame(-7, $date->intervalDays(new TDate('2013-08-25')));
        $date = new TDate('2013-11-01');
        $this->assertSame(30, $date->intervalDays(new TDate('2013-12-1')));
    }

    /**
     * Verifica se a hora é zerada quando a entrada tem hora
     */
    public function testInitZerosTime()
    {
        $this->assertSame('2013-05-01 00:00:00', (new TDate('2013-05-01 22:34:21'))->toString());
        $this->assertSame('2013-05-01 00:00:00', (new TDate(new DateTime('2013-05-01 22:34:21')))->toString());
        $this->assertSame('2013-05-01 00:00:00', (new TDate(['date' => '2013-05-01 22:34:21']))->toString());
        $this->assertInstanceOf(TDate::class, TDate::createDate('2013-05-01 22:34:21'));
    }

    /**
     * Verifica se a hora é zerada no timezone informado
     */
    public function testConstructTimestampWithTimezone()
    {
        $date = new TDate(1367366400, 'America/Sao_Paulo');
        $this->assertSame('2013-04-30 00:00:00', $date->toString());
        $this->assertSame('America/Sao_Paulo', $date->tzName);
    }
}
