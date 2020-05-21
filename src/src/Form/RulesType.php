<?php declare(strict_types = 1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RulesType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach (User::ROLES as $role) {
            $builder->add($role, CheckboxType::class, [
                'required' => false
            ]);
        }
        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('empty_data', null);
    }


    public function mapDataToForms($viewData, iterable $forms)
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!is_array($viewData)) {
            throw new UnexpectedTypeException($viewData, 'array');
        }
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        foreach ($viewData as $value) {
            $forms[$value]->setData(true);
        }
    }

    public function mapFormsToData(iterable $forms, &$viewData)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $viewData = [];
        foreach ($forms as $key => $value) {
            if ($value->getData() === true) {
                $viewData[] = $key;
            }
        }
    }
}