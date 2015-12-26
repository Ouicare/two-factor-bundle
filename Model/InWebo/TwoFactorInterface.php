<?php

namespace Scheb\TwoFactorBundle\Model\InWebo;

interface TwoFactorInterface {

    /**
     * Return the user name
     *
     * @return string
     */
    public function getUsername();

    /**
     * Return the Inwebo Authenticator secret
     * When an empty string or null is returned.
     *
     * @return string|null
     */
    public function getInWeboAuthenticatorSecret();

    /**
     * Set the Inwebo Authenticator secret
     *
     * @param integer $inweboAuthenticatorSecret
     */
    public function setInWeboAuthenticatorSecret($inweboAuthenticatorSecret);
}
