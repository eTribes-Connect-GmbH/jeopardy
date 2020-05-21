<?php declare(strict_types = 1);

namespace App\Controller\Profile;

use App\Entity\Skill;
use App\Entity\User;
use App\Repository\SkillRepository;
use App\Security\UserDataTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class IndexController extends AbstractController
{
    use UserDataTrait;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * ProfileController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(Request $request)
    {
        $userData = $this->getUserData($request);
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userData['email']]);
        /** @var SkillRepository $repository */
        $repository = $this->em->getRepository(Skill::class);

//        dd($repository->getTree($user->getId()));

        return $this->render('profile/index.html.twig', [
            'user' => $this->getUserData($request),
            'skills' => $repository->getTreeByUser($user),
        ]);
    }
}