<?php

namespace App\Form;

use App\Entity\Paintings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//for upload
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PaintingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('height')
            ->add('width')
            ->add('year')
            ->add('description')
            ->add('price')
            ->add('title')
            ->add('category')
            ->add('brochure', FileType::class, ['label' => 'Brochure (jpg file)'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paintings::class,
        ]);
    }
}
