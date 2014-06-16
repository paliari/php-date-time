<?php

namespace Paliari\DateTime;

use Carbon\Carbon,
    Exception,
    DomainException,
    DateTime;

/**
 * Class TDateTime
 * @package Paliari\DateTime
 */
class TDateTime extends Carbon
{
    const DATE_TIME_STR = 'Y-m-d H:i:s';
    const DATE_STR = 'Y-m-d';

    /**
     * Se o time for string ele aceita o formato TDateTime (d/m/Y H:i:s |d/m/YTH:i:s), não aceita formato americano (m/d/Y H:i:s)
     *
     * @param string|int|DateTime|object $time
     * @param DateTimeZone|string $tz
     *
     * @throw DomainException
     */
    public function __construct($time = null, $tz = null)
    {
        if (null !== $time) {
            $date = static::prepareDate($time);
            if (!$date) {
                throw new DomainException("Data $time inválida!");
            }
            $time = $date;
        }
        parent::__construct($time, $tz);
        $this->init();
    }

    protected function init()
    {
    }

    /**
     * Cria uma nova data TDateTime quando passado valor válido para $date
     *
     * @param string|int|TDateTime|null $date
     *
     * @return TDateTime
     * @throws \DomainException
     */
    public static function createDate($date = null)
    {
        if (!$date) {
            return null;
        }
        return new static($date);
    }
    /**
     * Retorna a data em string no formato universal
     *
     * @param $format
     *
     * @return string
     */
    public function toString($format)
    {
        return $this->format($format);
    }

    /**
     * Converte uma data para string formatada de acordo com o parametro passado.
     * Defaut: Y-m-d H:i:s
     *
     * @param string $format
     *
     * @return string
     */
    public function toDateTimeString($format = self::DATE_TIME_STR)
    {
        return $this->format($format);
    }

    /**
     * Converte uma data para string formatada de acordo com o parametro passado.
     * Defaut: Y-m-d
     *
     * @param string $format
     *
     * @return string
     */
    public function toDateString($format = self::DATE_STR)
    {
        return $this->format($format);
    }

    /**
     * Retorna uma data com o primeiro dia do mes.
     * @return TDateTime
     */
    public function firstDayOfMonth()
    {
        $firstDay = clone $this;

        return $firstDay->day(1)->hour(0)->minute(0)->second(0);
    }

    /**
     * Retorna o dia do ano de:
     *  1 a 365 para anos normais
     *  1 a 366 para anos bissextos
     * @return int
     */
    public function getDayOfYear()
    {
        return (int)$this->format('z');
    }

    /**
     * Altera apenas o dia
     *
     * @param  integer $value
     *
     * @return TDateTime
     */
    public function setDay($value)
    {
        return $this->day($value);
    }

    /**
     * Altera apenas o mes
     *
     * @param  integer $value
     *
     * @return TDateTime
     */
    public function setMonth($value)
    {
        return $this->month($value);
    }

    /**
     * Altera apenas o ano
     *
     * @param  integer $value
     *
     * @return TDateTime
     */
    public function setYear($value)
    {
        return $this->year($value);
    }

    /**
     * Altera apenas a hora
     *
     * @param  Integer $value
     *
     * @return TDateTime
     */
    public function setHour($value)
    {
        return $this->hour($value);
    }

    /**
     * Altera apenas os minutos
     *
     * @param  integer $value
     *
     * @return TDateTime
     */
    public function setMinute($value)
    {
        return $this->minute($value);
    }

    /**
     * Altera apenas os segundos
     *
     * @param  integer $value
     *
     * @return TDateTime
     */
    public function setSecond($value)
    {
        return $this->second($value);
    }

    /**
     * Retorna o ano de uma TDateTime
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Retorna os meses de uma TDateTime
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Retorna os dias de uma TDateTime
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Retorna as horas de uma TDateTime
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Retorna os minutos de uma TDateTime
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * Retorna os segundos de uma TDateTime
     * @return string
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * Retorna o objeto adicionando a quantidade de anos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addYear($value = 1)
    {
        return $this->addYears($value);
    }

    /**
     * Retorna o objeto adicionando a quantidade de meses passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addMonth($value = 1)
    {
        return $this->addMonths($value);
    }

    /**
     * Retorna o objeto adicionando a quantidade de dias passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addDay($value = 1)
    {
        return $this->addDays($value);
    }

    /**
     * Retorna o objeto adicionando a quantidade de horas passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addHour($value = 1)
    {
        return $this->addHours($value);
    }

    /**
     * Retorna o objeto adicionando a quantidade de minutos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addMinute($value = 1)
    {
        return $this->addMinutes($value);
    }

    /**
     * Retorna o objeto adicionando a quantidade de segundos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function addSecond($value = 1)
    {
        return $this->addSeconds($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de anos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subYear($value = 1)
    {
        return $this->subYears($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de meses passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subMonth($value = 1)
    {
        return $this->subMonths($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de dias passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subDay($value = 1)
    {
        return $this->subDays($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de horas passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subHour($value = 1)
    {
        return $this->subHours($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de minutos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subMinute($value = 1)
    {
        return $this->subMinutes($value);
    }

    /**
     * Retorna o objeto subtraindo a quantidade de segundos passado no parâmetro
     *
     * @param int $value
     *
     * @return TDateTime
     */
    public function subSecond($value = 1)
    {
        return $this->subSeconds($value);
    }

    /**
     * Retorna a quantidade de dias entre duas datas.
     * Se a segunda data não for passada retorna a diferença entre
     *  a data atual e a data passada.
     *
     * @param  TDateTime $end
     *
     * @return int    (Quantidade de dias entre as duas datas)
     */
    public function intervalDays($end = null)
    {
        $start = new TDateTime($this->toDateString());
        $end = new TDateTime($end ? $end->toDateString() : date(static::DATE_STR));
        $interval = $start->diff($end);

        return $interval->format('%r%a');
    }

    /**
     * Retorna se a data passada é maior ou menor que a data instanciada
     * Retorno:
     *  1 quando a data passada for maior
     *  0 quando as datas forem iguais
     *  -1 quando a data passada for menor
     *
     * @param TDateTime $date
     *
     * @return int
     */
    public function compareDate($date = null)
    {
        $start = new TDateTime($this->toDateString());
        $end = new TDateTime($date ? $date->toDateString() : date(static::DATE_STR));
        $interval = $end->diff($start);

        return (int)($interval->format('%r') . (bool)$interval->format('%a'));
    }

    /**
     * Retorna se a data passada é maior ou menor que a data instanciada
     * Retorno:
     *  1 quando a data passada for maior
     *  0 quando as datas forem iguais
     *  -1 quando a data passada for menor
     *
     * @param $date
     *
     * @deprecated Utilizar $date->compareDate($outraData);
     * @return int
     */
    public function compare($date = null)
    {
        return $this->compareDate($date);
    }

    /**
     * Verifica se o valor passado é um valor válido para uma data
     *
     * @param mixed $date
     *
     * @return bool
     */
    public static function isDate($date)
    {
        return (bool)static::prepareDate($date);
    }

    /**
     * Prepara data para validar.
     * @param mixed $date
     * @return null|string se for uma data valida retorna string no formato universal ou falso caso contrario.
     */
    protected static function prepareDate($date)
    {
        if (null === $date) {
            return null;
        }
        if ($date instanceof DateTime) {
            return static::timeToString($date->getTimestamp());
        } elseif (is_numeric($date)) {
            return static::timeToString($date);
        } elseif (self::hasTimestamp($date)) {
            return static::timeToString($date->getTimestamp());
        } elseif (is_string($date)) {
            return false !== strtotime($date) ? $date : null;
        }
        return null;
    }


    /**
     * Verifica se é um objeto contendo método getTimestamp
     *
     * @param mixed $date
     *
     * @return bool
     */
    protected static function hasTimestamp($date)
    {
        return is_object($date) && method_exists($date, 'getTimestamp');
    }

    /**
     * Converte timestamp em data universal.
     *
     * @param int $time timestamp
     * @return string
     */
    protected static function timeToString($time)
    {
        return date(static::DATE_TIME_STR, $time);
    }

    /**
     * Verifica se a data instanciada é futuro ignorando as horas.
     *
     * @param null $date
     *
     * @return bool
     */
    public function isFutureDayTo($date = null)
    {
        return $this->compareDate(new TDateTime($date)) == 1;
    }

    /**
     * Verifica se a data instanciada é passado ignorando as horas.
     *
     * @param null $date
     *
     * @return bool
     */
    public function isPastDayTo($date = null)
    {
        return $this->compareDate(new TDateTime($date)) == -1;
    }

}
