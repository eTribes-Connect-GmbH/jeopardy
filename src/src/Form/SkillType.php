<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Skill;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceListView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
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
            ->add('name')
            ->add('description')
            ->add('parentId', HiddenType::class)
            ->add('questionId', ChoiceType::class, [
                'choices' => $this->getChoices(),
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }

    /**
     * @return array
     */
    protected function getChoices(): array
    {
        $queryBuilder = $this->em->getRepository(Question::class)->createQueryBuilder('question');
        $queryBuilder->orderBy('question.question', 'ASC');

        $choices = [];
        /** @var Question $value */
        foreach ($queryBuilder->getQuery()->getResult() as $value) {
            $choices[$value->getQuestion()] = $value->getId();
        }
        return $choices;
    }
}
