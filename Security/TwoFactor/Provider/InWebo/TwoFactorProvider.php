<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google;

use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContext;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\Validation\CodeValidatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TwoFactorProvider implements TwoFactorProviderInterface {

    /**
     * @var \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\Validation\CodeValidatorInterface $authenticator
     */
    private $authenticator;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    private $templating;

    /**
     * @var string $formTemplate
     */
    private $formTemplate;

    /**
     * @var string $authCodeParameter
     */
    private $authCodeParameter;

    /**
     * Construct provider for Google authentication
     *
     * @param \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\Validation\CodeValidatorInterface $authenticator
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface                                  $templating
     * @param string                                                                                      $formTemplate
     * @param string                                                                                      $authCodeParameter
     */
    public function __construct(CodeValidatorInterface $authenticator, EngineInterface $templating, $formTemplate, $authCodeParameter) {
        $this->authenticator = $authenticator;
        $this->templating = $templating;
        $this->formTemplate = $formTemplate;
        $this->authCodeParameter = $authCodeParameter;
    }

    public function beginAuthentication(AuthenticationContext $context) {

    }

    public function requestAuthenticationCode(AuthenticationContext $context) {

    }

}
