<?php

namespace Cipika\Component\Event;

use Symfony\Component\EventDispatcher\Event;

class ProductViewEvent extends Event
{
    /**
     * Event data.
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     *
     * @param array
     */
    public function __construct($data)
    {
        if (!is_array($data)) {
            throw new \Exception('Data must be array.');
        }

        $this->data = $data;
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data.
     *
     * @param array
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
