<?php

namespace Paliari\DateTime;

/**
 * Class TDate
 * @package Sinergia\Brasil\TDateTime
 */
class TDate extends TDateTime
{
    /**
     * Se o time for string ele aceita o formato TDate (d/m/Y), não aceita formato americano (m/d/Y)
     *
     * @param string|int          $date
     * @param DateTimeZone|string $tz
     */
    public function __construct($date = null, $tz = null)
    {
        if (is_numeric($date)) {
            $date = date('Y-m-d', $date);
        } else {
            $date = TDateTime::strBrToUs($date);
        }

        return parent::__construct($date, $tz);
    }

    /**
     * Utilizado pelo construtor da classe
     *
     * @param $date
     *
     * @return int
     */
    protected function strBrToUs($date)
    {
        if (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/(\d{4})(T| ){0,1}(([0-1][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])){0,1}$/', $date, $datebit)) {
            @list($tudo, $dia, $mes, $ano, $tz) = $datebit;

            return "$ano-$mes-$dia";
        }

        return $date;
    }
}
