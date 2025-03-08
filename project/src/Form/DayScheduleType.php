<?php

namespace App\Form;

use App\Entity\DaySchedule;
use App\Enum\Grade;
use App\Enum\Schedule;
use App\Enum\WeekDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EnumType::class, ['class' => WeekDay::class, 'required' => true])
            ->add('schedule', EnumType::class, ['class' => Schedule::class, 'required' => true])
            ->add('grade', EnumType::class, ['class' => Grade::class, 'required' => true])
            ->add('subject', TextType::class, ['required' => true])
            ->add('teacher', TextType::class, ['required' => true])
            ->add('date', null, [
                'widget' => 'single_text',
                'required' => true
            ], DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DaySchedule::class,
        ]);
    }
}
