<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo;

use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContext;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Validation\CodeValidatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\InWeboAuthenticator;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TwoFactorProvider implements TwoFactorProviderInterface {

    /**
     * @var CodeValidatorInterface $authenticator
     */
    private $authenticator;

    /**
     * @var EngineInterface $templating
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
     * Construct provider for InWebo authentication
     *
     * @param CodeValidatorInterface $authenticator
     * @param EngineInterface                                  $templating
     * @param string                                                                                      $formTemplate
     * @param string                                                                                      $authCodeParameter
     */
    public function __construct(InWeboAuthenticator $authenticator, EngineInterface $templating, $formTemplate, $authCodeParameter) {
        $this->authenticator = $authenticator;
        $this->templating = $templating;
        $this->formTemplate = $formTemplate;
        $this->authCodeParameter = $authCodeParameter;
    }

    public function beginAuthentication(AuthenticationContext $context) {
// Check if user can do email authentication
        $user = $context->getUser();

        return $user instanceof TwoFactorInterface && $user->getInWeboAuthenticatorSecret();
    }

    public function requestAuthenticationCode(AuthenticationContext $context) {
        $user = $context->getUser();
        $request = $context->getRequest();
        $session = $context->getSession();
        // Display and process form
        $authCode = $request->get($this->authCodeParameter);
        if ($authCode !== null) {
            if ($this->authenticator->checkCode($user, $authCode)) {
                $context->setAuthenticated(true);

                return new RedirectResponse($request->getUri());
            } else {
                $session->getFlashBag()->set("two_factor", "scheb_two_factor.code_invalid");
            }
        }

        // Force authentication code dialog
        return $this->templating->renderResponse($this->formTemplate, array(
                    'useTrustedOption' => $context->useTrustedOption()
        ));
    }

}
