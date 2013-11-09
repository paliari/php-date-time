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
        parent::__construct($date, $tz);
        $this->hour = $this->minute = $this->second = 0;
    }
}
