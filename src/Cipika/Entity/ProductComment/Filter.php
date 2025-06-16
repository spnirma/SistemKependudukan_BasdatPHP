<?php

namespace Cipika\Entity\ProductComment;

class Filter
{ 
    protected $blacklistProvider;

    public function __construct(BlacklistProviderInterface $blacklistProvider)
    {   
        $this->blacklistProvider = $blacklistProvider;
    }   
    
    public function filter($comment)
    {   
        foreach ($this->blacklistProvider->getWords() as $word) {
            $comment = str_ireplace($word, str_repeat('*', strlen($word)), $comment);
        }
    
        return $comment;
    }   
}
