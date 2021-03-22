<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('createdAt')
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('endDate', DateTimeType::class, [
                'attr' => ['class' => 'form-control js-datepicker'],
                'label' => 'date de fin : ',
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-mm-yyyy',
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 'today',
                        'message' => 'la date ne peux pas être inférieur a aujourdhuit'
                    ]),
                                    ]
            ])
            //->add('isDone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
