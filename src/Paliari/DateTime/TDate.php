<?php

namespace Paliari\DateTime;

/**
 * Class TDate
 * @package Paliari\DateTime
 */
class TDate extends TDateTime
{
    /**
     * Seta zero para hora, minuto e segundo.
     */
    protected function init()
    {
        $this->setHour(0)->setMinute(0)->setSecond(0);
    }
}
