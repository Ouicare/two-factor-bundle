<?php

/**
 *
 * @author Anis Marrouchi <anismarrouchi@hotmail.com>
 * @copyright 2014 Ouicare
 * @package   TwoFactorBundle
 * @license http://http://opensource.org/licenses/mit-license.php MIT
 */

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo;

use Ouicare\InWebo\InWebo;
use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;

/**
 * The InWebo 2FA
 * @author Anis Marrouchi <anismarrouchi@hotmail.com>
 */
class InWeboAuthenticator {

    /**
     * @var InWebo $authenticator
     */
    var $authenicator;
    var $result;

    /**
     * Construct the InWebo authenticator
     * @param InWebo $authenticator
     */
    public function __construct(InWebo $authenticator) {
        $this->authenicator = $authenticator;
    }

    /**
     * Validates the code, which was entered by the user
     *
     * @param  TwoFactorInterface2 $user
     * @param  string                                                 $code
     * @return bool
     */
    public function checkCode(TwoFactorInterface $user, $code) {
        $result = $this->authenicator->AuthenticateREST($user->getUsername(), $code);
        $this->result = $this->authenicator->result;
        return $result;
    }

}
