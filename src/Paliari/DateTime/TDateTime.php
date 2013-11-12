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
    /**
     * Se o time for string ele aceita o formato TDateTime (d/m/Y H:i:s |d/m/YTH:i:s), não aceita formato americano (m/d/Y H:i:s)
     *
     * @param string|int|DateTime $time
     * @param DateTimeZone|string $tz
     */
    public function __construct($time = null, $tz = null)
    {
        if ($time instanceof DateTime) {
            $time = date('Y-m-d H:i:s', $time->getTimestamp());
        } elseif (is_numeric($time)) {
            $time = date('Y-m-d H:i:s', $time);
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

        try {
            return new static($date);
        } catch (Exception $e) {
            throw new DomainException("Data inválida!\n" . $e->getMessage());
        }
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
    public function toDateTimeString($format = 'Y-m-d H:i:s')
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
    public function toDateString($format = 'Y-m-d')
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
     * Retorna a quantidade de dias entre duas datas.
     * Se a segunda data não for passada retorna a diferença entre
     *  a data atual e a data passada.
     *
     * @param  TDateTime $datfim
     *
     * @return int    (Quantidade de dias entre as duas datas)
     */
    public function intervalDays($datfim = null)
    {
        $datini   = new TDateTime($this->toDateString());
        $datfim   = new TDateTime($datfim ? $datfim->toDateString() : date('Y-m-d'));
        $interval = $datini->diff($datfim);

        return $interval->format('%r%a');
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
     * @return int
     */
    public function compareDate($date = null)
    {
        $datini   = new TDateTime($this->toDateString());
        $datfim   = new TDateTime($date ? $date->toDateString() : date('Y-m-d'));
        $interval = $datini->diff($datfim);

        return (int)($interval->format('%r') . (bool)$interval->format('%a'));
    }
}
