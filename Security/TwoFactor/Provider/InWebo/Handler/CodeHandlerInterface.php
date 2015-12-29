<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Handler;

use Scheb\TwoFactorBundle\Model\ImWebo\TwoFactorInterface;

interface CodeHandlerInterface {

    /**
     * Gets an authentication code an persist it
     *
     * @param \Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface $user
     */
    public function getAndPersist(TwoFactorInterface $user);

    /**
     * Resets an authentication code an persist it
     *
     * @param \Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface $user
     */
    public function resetAndPersist(TwoFactorInterface $user);
}
