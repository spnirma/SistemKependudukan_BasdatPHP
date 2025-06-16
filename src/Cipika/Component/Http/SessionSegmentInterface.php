<?php

namespace Cipika\Component\Http;

interface SessionSegmentInterface
{
    public function get($key, $alt = null);

    public function set($key, $val);

    public function clear();

    public function getFlash($key, $alt = null);

    public function setFlash($key, $val);
}
