<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 10.01.19
 * Time: 20:09
 */

namespace App\Form;

use App\Entity\Comment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorName', TextType::class, array(
                'required' => true
            ))
            ->add('body', TextareaType::class, array(
                'required' => true
            ))
            ->add('submit', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
