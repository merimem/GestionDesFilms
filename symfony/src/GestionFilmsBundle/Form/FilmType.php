<?php

namespace GestionFilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('titre','text')
            ->add('description','textarea')
            ->add('categorie','entity',array(
                'class' => 'GestionFilmsBundle:Categorie',
                'choice_label' => 'nom',
            ))
            ->add('acteurs','entity',array(
                'class' => 'GestionFilmsBundle:Acteur',
                'choice_label'=>'prenomnom',
                'multiple' => true
            ))
            ->add('path','file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionFilmsBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionfilmsbundle_film';
    }
}
