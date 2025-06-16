<?php

namespace Cipika\View\Helper;

class DateTimeIntervalString {
    
    public function getInterval($timeIntervalValue, $typeInterval = 1, $timeInterval = "D")
    {
        if ($typeInterval != 1) {
            return "PT" . $timeIntervalValue . $timeInterval;
        } else {
            return "P" . $timeIntervalValue . $timeInterval;
        }
    }

}