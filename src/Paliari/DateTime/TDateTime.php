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
        $interval = $datfim->diff($datini);

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
        if (!$date) {
            return false;
        }
        if (is_string($date) && strlen($date) < 9) {
            return false;
        }
        try {
            new static($date);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
