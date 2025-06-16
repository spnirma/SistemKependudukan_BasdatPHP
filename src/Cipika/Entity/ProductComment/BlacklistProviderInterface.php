<?php

namespace Cipika\Entity\ProductComment;

interface BlacklistProviderInterface
{
    /**
     * provide blacklisted words
     *
     * @return array
     */
    public function getWords();
}
