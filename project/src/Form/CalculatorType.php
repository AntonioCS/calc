<?php

namespace App\Form;

use App\Dto\Calculator\CalcData;
use App\Service\Calculator\Operations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $ops = Operations::cases();
        $choices = [];

        foreach ($ops as $operation) {
            $choices[$operation->name] = $operation->value;
        }

        $builder
            ->add('valueA', NumberType::class, [
                'required' => true,
                'label' => 'Value: '
            ])
            ->add('valueB', NumberType::class, [
                'required' => true,
                'label' => 'Value: '
            ])
            ->add('operation', ChoiceType::class, [
                'required' => true,
                'choices' => $choices,
                'label' => 'Operation: '
            ])
            ->add('Calculate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalcData::class,
        ]);
    }
}
