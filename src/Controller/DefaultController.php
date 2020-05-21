<?php declare(strict_types = 1);

namespace App\Controller;

use App\Security\OAuthProvider;
use App\Security\TokenAuthenticator;
use App\Security\UserDataTrait;
use Auth0\SDK\Exception\CoreException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    use UserDataTrait;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var \App\Security\OAuthProvider
     */
    protected $provider;

    /**
     * DefaultController constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @param \App\Security\OAuthProvider $provider
     */
    public function __construct(SessionInterface $session, OAuthProvider $provider)
    {
        $this->session = $session;
        $this->provider = $provider;
    }


    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function default(Request $request)
    {
        $user = $this->getCurrentOAuthUser();

        return $this->render('default/default.html.twig', [
            'user' => $user,
            'wrongEmailDomain' => $this->isWrongEmailDomain($user)
        ]);
    }

    /**
     * @Route("/welcome", name="index_welcome", methods={"GET"})
     */
    public function welcome(Request $request)
    {
        return $this->render('default/welcome.html.twig', [
            'user' => $this->getUserData($request)
        ]);
    }

    /**
     * @Route("/login", name="index_login", methods={"GET"})
     */
    public function login()
    {
        $this->provider->createOAuth()->login();
    }

    /**
     * @Route("/logout", name="index_logout", methods={"GET"})
     */
    public function logout()
    {
        $this->provider->createOAuth()->logout();
    }

    protected function getCurrentOAuthUser(): ?array
    {
        try {
            return $this->provider->getOauth()->getUser();
        } catch (CoreException $e) {
            return null;
        }
    }

    protected function isWrongEmailDomain(?array $user)
    {
        if($user === null){
            return false;
        }

        return strpos($user['email'], TokenAuthenticator::ALLOWED_EMAIL_DOMAIN) === false;
    }
}