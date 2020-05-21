<?php declare(strict_types = 1);

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * AccessDeniedHandler constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $this->addFlash('error', $accessDeniedException->getMessage());
        return new RedirectResponse('/oops_an_error_occurred', Response::HTTP_TEMPORARY_REDIRECT);
    }

    /**
     * Adds a flash message to the current session for type.
     *
     * @throws \LogicException
     */
    protected function addFlash(string $type, string $message): void
    {
        $this->session->getFlashBag()->add($type, $message);
    }

}