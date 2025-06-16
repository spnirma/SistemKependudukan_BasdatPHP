<?php

namespace Cipika\Entity\ProductComment;

class DefaultBlacklistProvider implements BlacklistProviderInterface
{
    public function getWords()
    {
        return array(
            'anjing',
        );
    }
}
