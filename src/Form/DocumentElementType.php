<?php

namespace Parallalax\ApiClientBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentElementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('text_align', ChoiceType::class, array(
            'label' => false,
            'choices' => array('Gauche' => 'left', 'Droite' => 'right', 'Centrer' => 'center', 'Justifier' => 'justify'),
            'required' => false
        ));

        $builder->add('label', TextType::class, array(
            'label' => 'label',
            'required' => false));

        $builder->add('value', TextType::class, array(
            'label' => 'Valeur',
            'required' => false));

        $builder->add('position_x', TextType::class, array(
            'label' => 'position X',
            'required' => false));

        $builder->add('position_y', TextType::class, array(
            'label' => 'position Y',
            'required' => false));

        $builder->add('letter_spacing', TextType::class, array(
            'label' => 'Espacement',
            'required' => false));

        $builder->add('font_size', TextType::class, array(
            'label' => 'Taille police',
            'required' => false));

        $builder->add('letter_spacing', TextType::class, array(
            'label' => 'Espacement',
            'required' => false));

        $builder->add('width', TextType::class, array(
            'label' => 'Longueur',
            'required' => false));

        $builder->add('height', TextType::class, array(
            'label' => 'Hauteur',
            'required' => false));

        $builder->add('font_style', HiddenType::class, array(
            'label' => false,
            'required' => false));

        $builder->add('text_decoration', HiddenType::class, array(
            'label' => false,
            'required' => false));

        $builder->add('font_weight', HiddenType::class, array(
            'label' => false,
            'required' => false));

        $builder->add('submit', SubmitType::class, array(
            'label' => 'Enregistrer',
            'attr' => array('class' => 'btn btn-primary')));
    }
}
