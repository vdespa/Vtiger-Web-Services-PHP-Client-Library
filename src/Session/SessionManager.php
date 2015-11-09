<?php

namespace Vdespa\Vtiger\Session;

use Vdespa\Vtiger\Domain\Model\Session;

class SessionManager
{
    var $currentSession;

    public function setSession(Session $session)
    {
        $this->currentSession = $session;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        if ($this->currentSession instanceof Session === false)
        {
            throw new \RuntimeException('There is no session available');
        }

        return $this->currentSession;
    }

    /**
     * @return bool
     */
    public function sessionExists()
    {
        return ($this->currentSession instanceof Session === true);
    }
}