<?php


namespace App\Form;


use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('results')
            ->setMethod('GET')
            ->add('query', TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a query',
                        ]),
                        new Length([
                            'min' => 4,
                            'minMessage' => 'Your query should be at least {{ limit }} characters',
                            
                            'max' => 300,
                        ]),
                    ],
                ]
            )
                ->add('submit', SubmitType::class, [
                'label' => 'Search'
            ])
        ;
    }
    
}

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => Article::class,
//        ]);
//    }
