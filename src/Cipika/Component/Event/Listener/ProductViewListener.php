<?php

namespace Cipika\Component\Event\Listener;

use Symfony\Component\EventDispatcher\Event;

class ProductViewListener
{
    /**
     * Product view event.
     *
     *@param Event
     */
    public function onProductView(Event $event)
    {
        $data = $event->getData();
        if (!is_array($data)) {
            throw new \Exception('Data must be array.');
        }

        $this->incrementProductViewCount($data);

        $event->setData($data);
    }

    /**
     * Increment product view count
     *
     * @param array
     */
    protected function incrementProductViewCount(&$data)
    {
        // @todo increment product view count
        $defaultProductViewCount = 0;

        if (! isset($data['product_statistic'])) {
            $data['product_statistic'] = array();
        }

        if (!isset($data['product_statistic']['view_count'])) {
            $data['product_statistic']['view_count'] = $defaultProductViewCount;
        }

        $data['product_statistic']['view_count']++;
    }
}
