<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Handler;

use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;
use Scheb\TwoFactorBundle\Model\PersisterInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Handler\CodeHandlerInterface;

class CodeHandler implements CodeHandlerInterface {

    /**
     * @var \Scheb\TwoFactorBundle\Model\PersisterInterface $persister
     */
    private $persister;

    /**
     * Construct the code generator service
     *
     * @param \Scheb\TwoFactorBundle\Model\PersisterInterface       $persister
     */
    public function __construct(PersisterInterface $persister) {
        $this->persister = $persister;
    }

    /**
     * Gets an authentication code an persist it
     *
     * @param \Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface $user
     */
    public function getAndPersist(TwoFactorInterface $user, $code) {
        try {
            $user->setInWeboAuthenticatorSecret($code);
        } catch (\Exception $exc) {
            dump($exc->getMessage());
            die();
        }


        $this->persister->persist($user);
    }

    /**
     * Resets an authentication code an persist it
     *
     * @param \Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface $user
     */
    public function resetAndPersist(TwoFactorInterface $user) {
        $user->setInWeboAuthenticatorSecret(null);
        $this->persister->persist($user);
    }

}
