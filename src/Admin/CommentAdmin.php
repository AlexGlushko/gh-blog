<?php


namespace App\Admin;


use App\Entity\Article;
use App\Entity\Comment;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof Comment
            ? $object->getArticle()
            : 'Comment'; // shown in the breadcrumb on the create view
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', ['class' => 'col-md-9'])
            ->add('body', TextType::class)
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'id',
            ])
            ->add('authorName', TextType::class)
            ->end()
            
            ->with('Meta data', ['class' => 'col-md-3'])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->end()
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('body')
            ->add('article.title')
            ->add('authorName')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('body')
            ->add('article',null, [], EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'id',
            ])
        ;
    }
}
