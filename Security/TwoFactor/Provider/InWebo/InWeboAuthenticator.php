<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo;

use Ouicare\InWebo\InWebo;
use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;

class InWeboAuthenticator extends InWebo {

    public function __construct($serviceId, $wsdlProvisioningPath, $wsdlAuthenticationPath, $certPath, $certPassphrase, $iwApiBaseUrl, $withErrorTrace, $withRESTResultTrace) {
        parent::__construct($serviceId, $wsdlProvisioningPath, $wsdlAuthenticationPath, $certPath, $certPassphrase, $iwApiBaseUrl, $withErrorTrace, $withRESTResultTrace);
    }

    /**
     * Validates the code, which was entered by the user
     *
     * @param  \Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface $user
     * @param  string                                                 $code
     * @return bool
     */
    public function checkCode(TwoFactorInterface $user, $code) {
        return $this->AuthenticateREST($user->getUsername(), $code);
    }

}
