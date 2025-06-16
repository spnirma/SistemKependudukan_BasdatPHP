<?php

namespace Cipika\Monolog\Processor;

class SessionProcessor
{
    public function __invoke(array $record)
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($user = $session->get('member')) {
            $record['extra']['uid'] = $user->id_user;
        } elseif ($user = $session->get('partner')) {
            $record['extra']['uid'] = $user->id_user;
        } elseif ($user = $session->get('admin_session')) {
            $record['extra']['uid'] = $user->id_user;
        }

        return $record;
    }
}
