<?php

namespace AppBundle\Form;

use AppBundle\Entity\Car;
use AppBundle\Entity\Part;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('make', TextType::class)
          ->add('model', TextType::class)
          ->add('travelledDistance', IntegerType::class)
          ->add('parts', EntityType::class, [
            'class' => Part::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
          ])
          ->add('submit', SubmitType::class);

        /* TODO: Fix AJAX handling
         * $formModifier = function (FormInterface $form, ?string $make) {
            $form->add('model', EntityType::class, [
              'class' => Car::class,
              'query_builder' => function (CarRepository $repo) use ($make) {
                  return $repo->getAllModelsForMake($make);
              },
              'choice_label' => 'model',
              'placeholder' => '--- Please pick a Model ---',
            ]);
        };

        $builder->addEventListener(
          FormEvents::PRE_SET_DATA,
          function (FormEvent $event) use ($formModifier) {
              $car = $event->getData();
              $formModifier($event->getForm(), $car->getMake());
          });

        $builder->get('make')->addEventListener(
          FormEvents::POST_SUBMIT,
          function (FormEvent $event) use ($formModifier) {
              $car = $event->getForm()->getData();
              $formModifier($event->getForm()->getParent(), $car->getMake());
          }
        );*/
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => Car::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_car';
    }
}
