<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Record;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('release_date', null, [
                'widget' => 'single_text',
            ])
            ->add('description', null, ['required' => false])
            ->add('price')
            ->add('image_url', null, ['required' => false])
            ->add('available_stock')
            ->add('reserved_stock')
            ->add('sold')
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => null
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Record::class,
        ]);
    }
}
