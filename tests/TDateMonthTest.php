<?php
use Paliari\DateTime\TDateMonth;

class TDateMonthTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Verifica se a data é normalizada para o primeiro dia do mês à meia-noite
     */
    public function testInitNormalizesToFirstDayOfMonth()
    {
        $this->assertSame('2013-05-01 00:00:00', (new TDateMonth('2013-05-17 10:20:30'))->toString());
        $this->assertSame('2013-05-01 00:00:00', (new TDateMonth('2013-05-31'))->toString());
        $this->assertSame('2013-05-01 00:00:00', (new TDateMonth(new DateTime('2013-05-17 10:20:30')))->toString());
    }

    /**
     * Verifica se a normalização acontece no timezone informado
     */
    public function testInitWithTimezone()
    {
        $date = new TDateMonth(1367366400, 'America/Sao_Paulo');
        $this->assertSame('2013-04-01 00:00:00', $date->toString());
        $this->assertSame('America/Sao_Paulo', $date->tzName);
    }

    /**
     * Verifica se a conversão para string retorna m/Y
     */
    public function testToString()
    {
        $date = new TDateMonth('2013-05-17 10:20:30');
        $this->assertSame('05/2013', (string)$date);
        $this->assertSame('05/2013', "$date");
        $this->expectOutputString('05/2013');
        echo $date;
    }

    /**
     * Verifica se toString() continua no formato Y-m-d H:i:s
     */
    public function testToStringMethodKeepsFullFormat()
    {
        $date = new TDateMonth('2013-12-25');
        $this->assertSame('2013-12-01 00:00:00', $date->toString());
        $this->assertSame('2013-12-01', $date->toDateString());
    }

    /**
     * Verifica se createDate retorna uma instância de TDateMonth
     */
    public function testCreateDate()
    {
        $date = TDateMonth::createDate('2013-05-17');
        $this->assertInstanceOf(TDateMonth::class, $date);
        $this->assertSame('05/2013', (string)$date);
        $this->assertNull(TDateMonth::createDate(''));
    }
}
