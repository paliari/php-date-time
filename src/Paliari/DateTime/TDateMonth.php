<?php

namespace Paliari\DateTime;

/**
 * Class TDateMonth
 * @package Paliari\DateTime
 */
class TDateMonth extends TDateTime
{
    protected function init()
    {
        $this->setDay(1)->setHour(0)->setMinute(0)->setSecond(0);
    }

    /**
     * Retona data em string para ser impressa.
     * @return bool|string
     */
    public function __toString(){
        return $this->format('m/Y');
    }
}
