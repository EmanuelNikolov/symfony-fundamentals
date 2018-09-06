<?php

namespace AppBundle\Form;

use AppBundle\Entity\Part;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartPickerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', EntityType::class, [
          'class' => Part::class,
          'choice_label' => 'name',
          'placeholder' => '--- Please pick a Part ---',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => Part::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_part_picker_type';
    }
}
