<?php
use Paliari\DateTime\TDateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

class TDateTimeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TDateTime
     */
    public $date;

    /**
     * @var TDateTime
     */
    public $dateTime;

    protected function setUp(): void
    {
        $this->date     = new TDateTime('2013-05-01');
        $this->dateTime = new TDateTime('2013-05-01 22:34:21');
    }

    /**
     * Testa de 2010 a 2030 se todos dias estão sendo gerados corretamente pelo DateBr
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
            $date_br   = new TDateTime("$ano-$mes-$dia");
            $this->assertEquals($timestamp, $date_br->timestamp);
        }
    }

    /**
     * Testa o construtor do DateBr passando timestemp por 30 dias
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
            $tmstp  = mktime($H, $i, $s, $m, $d + 1, $Y);
            $d      = date('d', $tmstp);
            $m      = date('m', $tmstp);
            $Y      = date('Y', $tmstp);
            $H      = date('H', $tmstp);
            $i      = date('i', $tmstp);
            $s      = date('s', $tmstp);
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
        $date = new TDateTime('2013-10-01');
        $this->assertSame(30, $date->intervalDays(new TDateTime('2013-10-31')));
        $date = new TDateTime('2013-09-01');
        $this->assertSame(-7, $date->intervalDays(new TDateTime('2013-08-25')));
        $date = new TDateTime('2013-11-01');
        $this->assertSame(30, $date->intervalDays(new TDateTime('2013-12-1')));
        $this->assertSame(0, $date->intervalDays(new TDateTime('2013-11-01 23:59:59')));
    }

    /**
     * Verifica se timestamp com timezone preserva o instante e converte para o timezone informado
     */
    public function testConstructTimestampWithTimezone()
    {
        $timestamp = 1367366400;
        $date      = new TDateTime($timestamp, 'America/Sao_Paulo');
        $this->assertSame($timestamp, $date->timestamp);
        $this->assertSame('America/Sao_Paulo', $date->tzName);
        $this->assertSame('2013-04-30 21:00:00', $date->toString());
        $this->assertSame(
            \Carbon\Carbon::createFromTimestamp($timestamp, 'America/Sao_Paulo')->toDateTimeString(),
            $date->toString()
        );
        $date = new TDateTime((string)$timestamp, new DateTimeZone('America/Sao_Paulo'));
        $this->assertSame($timestamp, $date->timestamp);
    }

    /**
     * Verifica se timestamp sem timezone usa o timezone padrao
     */
    public function testConstructTimestampWithoutTimezone()
    {
        $timestamp = 1367366400;
        $date      = new TDateTime($timestamp);
        $this->assertSame($timestamp, $date->timestamp);
        $this->assertSame(date_default_timezone_get(), $date->tzName);
        $this->assertSame(date(TDateTime::DATE_TIME_STR, $timestamp), $date->toString());
    }

    /**
     * Verifica se DateTime com timezone preserva o instante
     */
    public function testConstructDateTimeWithTimezone()
    {
        $dateTime = new DateTime('2013-05-01 10:00:00', new DateTimeZone('America/Sao_Paulo'));
        $date     = new TDateTime($dateTime, 'America/Sao_Paulo');
        $this->assertSame($dateTime->getTimestamp(), $date->timestamp);
        $this->assertSame('2013-05-01 10:00:00', $date->toString());
        $date = new TDateTime($dateTime, 'UTC');
        $this->assertSame($dateTime->getTimestamp(), $date->timestamp);
        $this->assertSame('2013-05-01 13:00:00', $date->toString());
    }

    /**
     * Verifica se o dia do ano continua em base 0
     */
    public function testGetDayOfYear()
    {
        $this->assertSame(0, (new TDateTime('2013-01-01'))->getDayOfYear());
        $this->assertSame(120, (new TDateTime('2013-05-01'))->getDayOfYear());
        $this->assertSame(365, (new TDateTime('2012-12-31'))->getDayOfYear());
    }

    /**
     * Verifica se datas com barra continuam sendo lidas no formato americano (m/d/Y)
     */
    public function testConstructSlashDateIsAmerican()
    {
        $this->assertSame('2013-05-01', (new TDateTime('05/01/2013'))->toDateString());
    }

    /**
     * Verifica o retorno de compareDate.
     */
    public function testCompareDate()
    {
        $date = new TDateTime('2013-10-01');
        $this->assertEquals(1, $date->compareDate(new TDateTime('2013-09-25')));
        $this->assertEquals(0, $date->compareDate(new TDateTime('2013-10-01')));
        $this->assertEquals(-1, $date->compareDate(new TDateTime('2013-10-25')));
    }

    /**
     * Verifica se o create date está funcionando normalmente
     */
    public function testCreateDate()
    {
        $this->assertEqualsWithDelta(time(), TDateTime::createDate('now')->timestamp, 2);
        $this->assertEquals('2013-11-07 00:00:00', TDateTime::createDate('2013-11-07')->toDateTimeString());
        $data = new TDateTime('2013-09-09');
        $this->assertEquals('2013-09-09', TDateTime::createDate($data)->toDateString());
        $this->assertEquals($data, new TDateTime($data));
        $timestamp = 1383831921;
        foreach ([DateTime::RSS, DateTime::W3C, DateTime::COOKIE, TDateTime::DATE_TIME_STR, DateTime::ATOM] as $format) {
            $date = date($format, $timestamp);
            $this->assertSame($timestamp, TDateTime::createDate($date)->timestamp, $format);
        }
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
     */
    public function testException()
    {
        $this->expectException(DomainException::class);
        TDateTime::createDate('nogsgsw');
    }

    /**
     * Verifica se parametro errado gera excecao
     */
    public function testExceptionNew()
    {
        $this->expectException(DomainException::class);
        new TDateTime('nogsgsw');
    }

    /**
     * Testa se o isDate está validando o argumento corretamente
     */
    public function testIsDate()
    {
        $this->assertTrue(TDateTime::isDate(time()));
        $this->assertTrue(TDateTime::isDate('2013-11-15'));
        $this->assertTrue(TDateTime::isDate(date('Y-m-d')));
        $this->assertTrue(TDateTime::isDate(date(DateTime::RSS)));
        $this->assertTrue(TDateTime::isDate(date(DateTime::W3C)));
        $this->assertTrue(TDateTime::isDate(date(DateTime::COOKIE)));
        $this->assertTrue(TDateTime::isDate(date(TDateTime::DATE_TIME_STR)));
        $this->assertTrue(TDateTime::isDate(date(DateTime::ATOM)));
        $this->assertTrue(TDateTime::isDate('now'));
        $this->assertTrue(TDateTime::isDate('132'));
        $this->assertFalse(TDateTime::isDate('abc'));
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddYear()
    {
        $this->assertEquals('2015-05-01', $this->date->addYears(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubYear()
    {
        $this->assertEquals('2011-05-01', $this->date->subYears(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddMonths()
    {
        $this->assertEquals('2013-07-01', $this->date->addMonths(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubMonth()
    {
        $this->assertEquals('2013-03-01', $this->date->subMonths(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddDays()
    {
        $this->assertEquals('2013-05-03', $this->date->addDays(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubDays()
    {
        $this->assertEquals('2013-04-29', $this->date->subDays(2)->toDateString());
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddHour()
    {
        $this->assertEquals('2013-05-01 02:00:00', $this->date->addHours(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubHour()
    {
        $this->assertEquals('2013-04-30 22:00:00', $this->date->subHours(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddMinute()
    {
        $this->assertEquals('2013-05-01 00:02:00', $this->date->addMinutes(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubMinute()
    {
        $this->assertEquals('2013-04-30 23:58:00', $this->date->subMinutes(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao esta adicionando o valor passado na propriedade
     */
    public function testAddSecond()
    {
        $this->assertEquals('2013-05-01 00:00:02', $this->date->addSeconds(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao esta subtraindo o valor passado na propriedade
     */
    public function testSubSecond()
    {
        $this->assertEquals('2013-04-30 23:59:58', $this->date->subSeconds(2)->toDateTimeString());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetYear()
    {
        $this->assertEquals(2013, $this->dateTime->getYear());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetMonths()
    {
        $this->assertEquals(5, $this->dateTime->getMonth());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetDays()
    {
        $this->assertEquals(1, $this->dateTime->getDay());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetHour()
    {
        $this->assertEquals(22, $this->dateTime->getHour());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetMinute()
    {
        $this->assertEquals(34, $this->dateTime->getMinute());
    }

    /**
     * Verifica se a funcao get está retornando o valor correto.
     */
    public function testGetSecond()
    {
        $this->assertEquals(21, $this->dateTime->getSecond());
    }

    /**
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetYear()
    {
        $this->assertEquals(2015, $this->dateTime->setYear(2015)->format('Y'));
    }

    /**
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetMonths()
    {
        $this->assertEquals(10, $this->dateTime->setMonth(10)->format('m'));
    }

    /**
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetDays()
    {
        $this->assertEquals(6, $this->dateTime->setDay(6)->format('d'));
    }

    /**
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetHour()
    {
        $this->assertEquals(18, $this->dateTime->setHour(18)->format('H'));
    }

    /**
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetMinute()
    {
        $this->assertEquals(45, $this->dateTime->setMinute(45)->format('i'));
    }

    /**
     *
     * Verifica se a propriedade está sendo setada corretamente
     */
    public function testSetSecond()
    {
        $this->assertEquals(17, $this->dateTime->setSecond(17)->format('s'));
    }

    /**
     *
     * Verifica se isFutureDay está retornando o esperado.
     */
    public function testIsFutureDay()
    {
        $this->assertEquals(false, $this->dateTime->isFutureDayTo());
        $this->dateTime->setYear(5000);
        $this->assertEquals(true, $this->dateTime->isFutureDayTo());
    }

    /**
     *
     * Verifica se isFutureDay está retornando o esperado.
     */
    public function testIsPastDay()
    {
        $this->assertEquals(true, $this->dateTime->isPastDayTo());
        $this->dateTime->setYear(5000);
        $this->assertEquals(false, $this->dateTime->isPastDayTo());
    }

    public static function addSubWrapperProvider(): array
    {
        return [
            'addYear'           => ['addYear', 2, '2015-05-01 12:30:30'],
            'addYear default'   => ['addYear', null, '2014-05-01 12:30:30'],
            'addMonth'          => ['addMonth', 2, '2013-07-01 12:30:30'],
            'addMonth default'  => ['addMonth', null, '2013-06-01 12:30:30'],
            'addDay'            => ['addDay', 2, '2013-05-03 12:30:30'],
            'addDay default'    => ['addDay', null, '2013-05-02 12:30:30'],
            'addHour'           => ['addHour', 2, '2013-05-01 14:30:30'],
            'addHour default'   => ['addHour', null, '2013-05-01 13:30:30'],
            'addMinute'         => ['addMinute', 2, '2013-05-01 12:32:30'],
            'addMinute default' => ['addMinute', null, '2013-05-01 12:31:30'],
            'addSecond'         => ['addSecond', 2, '2013-05-01 12:30:32'],
            'addSecond default' => ['addSecond', null, '2013-05-01 12:30:31'],
            'subYear'           => ['subYear', 2, '2011-05-01 12:30:30'],
            'subYear default'   => ['subYear', null, '2012-05-01 12:30:30'],
            'subMonth'          => ['subMonth', 2, '2013-03-01 12:30:30'],
            'subMonth default'  => ['subMonth', null, '2013-04-01 12:30:30'],
            'subDay'            => ['subDay', 2, '2013-04-29 12:30:30'],
            'subDay default'    => ['subDay', null, '2013-04-30 12:30:30'],
            'subHour'           => ['subHour', 2, '2013-05-01 10:30:30'],
            'subHour default'   => ['subHour', null, '2013-05-01 11:30:30'],
            'subMinute'         => ['subMinute', 2, '2013-05-01 12:28:30'],
            'subMinute default' => ['subMinute', null, '2013-05-01 12:29:30'],
            'subSecond'         => ['subSecond', 2, '2013-05-01 12:30:28'],
            'subSecond default' => ['subSecond', null, '2013-05-01 12:30:29'],
        ];
    }

    /**
     * Verifica os atalhos add* e sub* da TDateTime (com valor e com o padrão 1),
     * e se alteram a própria instância
     */
    #[DataProvider('addSubWrapperProvider')]
    public function testAddSubWrappers(string $method, ?int $value, string $expected)
    {
        $date   = new TDateTime('2013-05-01 12:30:30');
        $result = null === $value ? $date->$method() : $date->$method($value);
        $this->assertSame($date, $result);
        $this->assertSame($expected, $date->toString());
    }

    /**
     * Verifica se firstDayOfMonth retorna uma cópia no primeiro dia do mês sem alterar o original
     */
    public function testFirstDayOfMonth()
    {
        $date  = new TDateTime('2013-05-17 10:20:30');
        $first = $date->firstDayOfMonth();
        $this->assertInstanceOf(TDateTime::class, $first);
        $this->assertNotSame($date, $first);
        $this->assertSame('2013-05-01 00:00:00', $first->toString());
        $this->assertSame('2013-05-17 10:20:30', $date->toString());
    }

    /**
     * Verifica a conversão para o formato json
     */
    public function testJson()
    {
        $this->assertSame('2013-05-01T22:34:21', $this->dateTime->as_json());
        $this->assertSame('2013-05-01T22:34:21', $this->dateTime->to_json());
    }

    /**
     * Verifica se o compare depreciado continua igual ao compareDate
     */
    public function testCompareDeprecated()
    {
        $date = new TDateTime('2013-10-01');
        $this->assertSame(1, $date->compare(new TDateTime('2013-09-25')));
        $this->assertSame(0, $date->compare(new TDateTime('2013-10-01 23:00:00')));
        $this->assertSame(-1, $date->compare(new TDateTime('2013-10-25')));
    }

    /**
     * Verifica a criação a partir de array com a chave date
     */
    public function testConstructFromArray()
    {
        $this->assertSame('2013-05-01 10:00:00', (new TDateTime(['date' => '2013-05-01 10:00:00']))->toString());
    }

    /**
     * Verifica a criação a partir de objetos com getTimestamp que não estendem DateTime
     */
    public function testConstructFromTimestampObject()
    {
        $immutable = new DateTimeImmutable('2013-05-01 10:00:00', new DateTimeZone('America/Sao_Paulo'));
        $date      = new TDateTime($immutable);
        $this->assertSame($immutable->getTimestamp(), $date->timestamp);

        $object = new class {
            public function getTimestamp()
            {
                return 1367366400;
            }
        };
        $this->assertSame(1367366400, (new TDateTime($object))->timestamp);
    }

    /**
     * Verifica que '0' e 0 são datas válidas (epoch) e que valores vazios retornam null
     */
    public function testCreateDateZeroAndEmpty()
    {
        $this->assertSame(0, TDateTime::createDate('0')->timestamp);
        $this->assertSame(0, TDateTime::createDate(0)->timestamp);
        $this->assertNull(TDateTime::createDate(null));
        $this->assertNull(TDateTime::createDate(''));
        $this->assertNull(TDateTime::createDate(false));
    }

    /**
     * Verifica isDate com valores vazios, objetos e arrays
     */
    public function testIsDateEdgeCases()
    {
        $this->assertFalse(TDateTime::isDate(null));
        $this->assertFalse(TDateTime::isDate(''));
        $this->assertFalse(TDateTime::isDate(['x' => 1]));
        $this->assertFalse(TDateTime::isDate(new stdClass()));
        $this->assertTrue(TDateTime::isDate(new DateTime('2013-05-01')));
        $this->assertTrue(TDateTime::isDate(new DateTimeImmutable('2013-05-01')));
        $this->assertTrue(TDateTime::isDate(['date' => '2013-05-01']));
    }

    /**
     * Verifica compareDate e intervalDays sem argumento (comparação com hoje)
     */
    public function testCompareWithToday()
    {
        $this->assertSame(1, (new TDateTime('+3 days'))->compareDate());
        $this->assertSame(0, (new TDateTime('today'))->compareDate());
        $this->assertSame(-1, (new TDateTime('-3 days'))->compareDate());
        $this->assertSame(-3, (new TDateTime('+3 days'))->intervalDays());
        $this->assertSame(0, (new TDateTime('today'))->intervalDays());
        $this->assertSame(3, (new TDateTime('-3 days'))->intervalDays());
    }

    /**
     * Verifica isFutureDayTo e isPastDayTo com data informada, ignorando as horas
     */
    public function testIsFutureAndPastDayToWithArgument()
    {
        $date = new TDateTime('2013-05-01 10:00:00');
        $this->assertTrue($date->isFutureDayTo('2013-04-30'));
        $this->assertFalse($date->isFutureDayTo('2013-05-02'));
        $this->assertTrue($date->isPastDayTo('2013-05-02'));
        $this->assertFalse($date->isPastDayTo('2013-04-30'));
        $this->assertFalse($date->isFutureDayTo('2013-05-01 08:00:00'));
        $this->assertFalse($date->isPastDayTo('2013-05-01 23:00:00'));
    }

    /**
     * Verifica o overflow de mês herdado do Carbon (31/01 + 1 mês = 03/03)
     */
    public function testAddMonthOverflow()
    {
        $this->assertSame('2013-03-03', (new TDateTime('2013-01-31'))->addMonth()->toDateString());
        $this->assertSame('2013-02-28', (new TDateTime('2013-01-31'))->addMonthsNoOverflow(1)->toDateString());
        $this->assertSame('2013-03-01', (new TDateTime('2012-02-29'))->addYear()->toDateString());
    }

    /**
     * Verifica o dia do ano (base 0) em anos bissextos
     */
    public function testGetDayOfYearLeapYear()
    {
        $this->assertSame(59, (new TDateTime('2013-03-01'))->getDayOfYear());
        $this->assertSame(60, (new TDateTime('2012-03-01'))->getDayOfYear());
    }
}
