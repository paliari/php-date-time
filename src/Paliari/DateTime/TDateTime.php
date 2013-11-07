<?php

namespace Paliari\DateTime;

use Carbon\Carbon,
    Exception,
    DomainException;

class TDateTime extends Carbon
{
    /**
     * Se o time for string ele aceita o formato TDateTime (d/m/Y H:i:s |d/m/YTH:i:s), não aceita formato americano (m/d/Y H:i:s)
     *
     * @param string|int          $time
     * @param DateTimeZone|string $tz
     */
    public function __construct($time = null, $tz = null)
    {
        if (is_numeric($time)) {
            $time = date('Y-m-d H:i:s', $time);
        }

        return parent::__construct($time, $tz);
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
     * @param $format
     *
     * @return string
     */
    public function toString($format)
    {
        return ($this->hour || $this->minute || $this->second) ? $this->toDateTimeString($format) : $this->toDateString();
    }

    /**
     * Converte um timestamp para determinado valor para formato do XML padrao ABRASF
     *
     * @param timestamp $value
     *
     * @return string
     */
    public static function dateTimeToXMLValue($value)
    {
        if (!$value) {
            return null;
        }

        return date('Y-m-d\TH:i:s', $value);
    }

    /**
     * Converte uma timestamp para determinado valor para formato do XML padrao ABRASF
     *
     * @param timestamp $date
     *
     * @return string
     */
    public static function dateToXMLValue($date)
    {
        if (!$date) {
            return null;
        }

        return date('Y-m-d', $date);
    }

    /**
     * Converte uma TDate para string formatada de acordo com o parametro passado.
     * Defaut: Y-m-d H:i:s
     *
     * @param  string $format
     *
     * @return string
     */
    public function dateTimeToString($format = 'Y-m-d H:i:s')
    {
        return static::toDateTimeString($format);
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
     * @return Carbon  TDate
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
     * @return Carbon  TDate
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
     * @return Carbon  TDate
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
     * @return Carbon  TDate
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
     * @return Carbon  TDate
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
     * @return Carbon  TDate
     */
    public function setSecond($value)
    {
        return $this->second($value);
    }

    /**
     * Retorna o ano de uma TDate
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Retorna os meses de uma TDate
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Retorna os dias de uma TDate
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Retorna as horas de uma TDate
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Retorna os minutos de uma TDate
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * Retorna os segundos de uma TDate
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
     * @param  TDateTime $datini
     * @param  TDateTime $datfim
     *
     * @return int    (Quantidade de dias entre as duas datas)
     */
    public static function intervalDays(TDateTime $datini, TDateTime $datfim = null)
    {
        $datini = new TDateTime($datini->toDateString());
        $datfim = new TDateTime($datfim ? $datfim->toDateString() : date('Y-m-d'));

        $interval = $datini->diff($datfim);

        return $interval->format('%a');
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
    public function compareDate($date)
    {
        $datini   = new TDateTime($this->toDateString());
        $datfim   = new TDateTime($date ? $date->toDateString() : date('Y-m-d'));
        $interval = $datini->diff($datfim);
        $operacao = $interval->format('%R');
        $numero   = $interval->format('%a');

        return '0' === $numero ? 0 : ('+' === $operacao ? 1 : -1);
    }
}
