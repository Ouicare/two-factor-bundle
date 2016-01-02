<?php

namespace Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo;

use Scheb\TwoFactorBundle\Model\InWebo\TwoFactorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContext;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Validation\CodeValidatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\TwoFactorProviderInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\InWeboAuthenticator;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Handler\CodeHandler;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\InWebo\Validation\BackupCodeValidator;

class TwoFactorProvider implements TwoFactorProviderInterface {

    /**
     * @var CodeValidatorInterface $authenticator
     */
    private $authenticator;

    /**
     * @var CodeHandler $codeHandler
     */
    private $codeHandler;

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
     * @var boolean $checkOnce
     */
    private $checkOnce;

    /**
     * Construct provider for InWebo authentication
     *
     * @param CodeValidatorInterface $authenticator
     * @param EngineInterface                                  $templating
     * @param string                                                                                      $formTemplate
     * @param string                                                                                      $authCodeParameter
     */
    public function __construct(CodeValidatorInterface $authenticator, CodeHandler $codeHandler, EngineInterface $templating, $formTemplate, $authCodeParameter, $checkOnce) {
        $this->authenticator = $authenticator;
        $this->codeHandler = $codeHandler;
        $this->templating = $templating;
        $this->formTemplate = $formTemplate;
        $this->authCodeParameter = $authCodeParameter;
        $this->checkOnce = $checkOnce;
    }

    public function beginAuthentication(AuthenticationContext $context) {
        //Persist into database to be used for cookie check and check once authentification
        $user = $context->getUser();
        $beginAuth = !$user->getInWeboAuthenticatorSecret() & $this->checkOnce;
        return $user instanceof TwoFactorInterface && $beginAuth;
    }

    public function requestAuthenticationCode(AuthenticationContext $context) {

        $user = $context->getUser();
        $request = $context->getRequest();
        $session = $context->getSession();
        // Display and process form
        $authCode = $request->get($this->authCodeParameter);
        if ($authCode !== null) {
            $result = $this->authenticator->checkCode($user, $authCode);
            if ($result) {
//get the inwebo alias
                $alias = $result['alias'];
                //Persist the alias to the database to be used in case we do 2FA only once
                $this->codeHandler->getAndPersist($user, $alias);
                $context->setAuthenticated(true);
                return new RedirectResponse($request->getUri());
            } else {
                $session->getFlashBag()->set("two_factor", "scheb_two_factor.code_invalid");
            }
        }
        //die();
        // Force authentication code dialog
        return $this->templating->renderResponse($this->formTemplate, array(
                    'useTrustedOption' => $context->useTrustedOption()
        ));
    }

}
