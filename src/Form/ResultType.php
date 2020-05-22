<?php

namespace App\Form;

use App\Entity\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionId', HiddenType::class)
            ->add('skillId', HiddenType::class)
            ->add('userId', HiddenType::class)
            ->add('result',RangeType::class,[
                'attr' => [
                    'min' => 0,
                    'max' => 6,
                    'step' => 1,
                    'class' => 'custom-range'
                ],
                'help' => 'From 0 - 6',
                'required' => true,
            ])
            ->add('learn');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Result::class,
        ]);
    }
}
