<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Validation;

use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;

class InWeboCodeValidator implements CodeValidatorInterface {

    /**
     * Validates the code, which was entered by the user
     *
     * @param  \Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface $user
     * @param  integer                                               $code
     * @return bool
     */
    public function checkCode(TwoFactorInterface $user, $code) {
        return $user->getInWeboAuthenticatorSecret() == $code;
    }

}
