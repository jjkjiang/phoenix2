<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime();
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('eventUrl', TextType::class)
            ->add('date', DateType::class, [
                'years' => [
                    $date->format('Y'),
                    (int)($date->format('Y'))+1
                ]
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Time (24 hour format)',
            ])
            ->add('image', FileType::class, [
                'label' => 'Event Image',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event',
        ));
    }
}
