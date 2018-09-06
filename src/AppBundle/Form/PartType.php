<?php

namespace AppBundle\Form;

use AppBundle\Entity\Part;
use AppBundle\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
          ->add('price', NumberType::class, [
            'scale' => 2,
          ])
          ->add('quantity', IntegerType::class, [
            'data' => Part::QUANTITY_DEFAULT,
          ])
          ->add('supplier', EntityType::class, [
            'class' => Supplier::class,
            'choice_label' => 'name',
          ])
          ->add('submit', SubmitType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
          function (FormEvent $event) {
              $part = $event->getData();
              $form = $event->getForm();

              if (null !== $part->getId()) {
                  $form->remove('name')
                    ->remove('supplier');
              }
          });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => Part::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_part';
    }
}
