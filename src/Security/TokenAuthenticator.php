<?php declare(strict_types = 1);

namespace App\Security;

use App\Entity\Skill;
use App\Entity\User;
use Auth0\SDK\Exception\CoreException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public const ALLOWED_EMAIL_DOMAIN = '@etribes.de';

    private $em;

    /**
     * @var \App\Security\OAuthProvider
     */
    protected $provider;

    /**
     * @var Session
     */
    protected $session;

    public function __construct(EntityManagerInterface $em, OAuthProvider $provider, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
        $this->provider = $provider;
    }


    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        try {
            $user = $this->provider->getOauth()->getUser();
        } catch (CoreException $e) {
            return false;
        }
        if ($user === null) {
            return false;
         }

        if (strpos($user['email'], static::ALLOWED_EMAIL_DOMAIN) === false) {
            return false;
        }

        return true;
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return false;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $user = $this->provider->getOauth()->getUser();
        } catch (CoreException $e) {
            return null;
        }

        if ($user === null) {
            return null;
        }

        if (strpos($user['email'], static::ALLOWED_EMAIL_DOMAIN) === false) {
            $this->session->getFlashBag()->add('danger', 'wrong emailDomain');
            return null;
        }

        $userEntity = $this->em->getRepository(User::class)->findOneBy(['email' => $user['email']]);
        $defaultSkill = $this->em->getRepository(Skill::class)->find(1);

        if (!$userEntity) {
            $userEntity = new User();
            $userEntity->setEmail($user['email']);
            $userEntity->setRoles(['user']);
            $userEntity->setPassword($user['sub']);
            $userEntity->setRootSkill($defaultSkill);
            $this->em->persist($userEntity);
            $this->em->flush();
        }

        $this->session->set('user', json_encode($user));
        return $userEntity;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());
        $this->session->getFlashBag()->add('danger', $message);

        return new RedirectResponse('/', Response::HTTP_FOUND);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $this->session->set('wrong_email_domain', false);
        $message = 'Authentication Required';
        $this->session->getFlashBag()->add('info', $message);

        return new RedirectResponse('/', Response::HTTP_FOUND);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}