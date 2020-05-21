<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Doctrine\ORM\QueryBuilder;

class UserType extends AbstractType
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * SkillType constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', HiddenType::class)
            ->add('roles', RulesType::class)
            ->add('password', HiddenType::class)
            ->add('rootSkillId', ChoiceType::class, [
                'choices' => $this->getChoices(),
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * @return array
     */
    protected function getChoices(): array
    {
        /** @var \Doctrine\ORM\QueryBuilder $queryBuilder */
        $queryBuilder = $this->em->getRepository(Skill::class)->createQueryBuilder('skill');
        $queryBuilder->where($queryBuilder->expr()->eq('skill.parentId', ':parentId'));
        $queryBuilder->setParameter('parentId', Skill::ROOT_SKILL);
        $queryBuilder->orderBy('skill.id', 'ASC');

        $choices = [];
        /** @var Skill $value */
        foreach ($queryBuilder->getQuery()->getResult() as $value) {
            $choices[$value->getName()] = $value->getId();
        }
        return $choices;
    }
}
