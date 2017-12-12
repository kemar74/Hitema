<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\Category;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('title', null, ['label' => 'Titre du livre : '])
			->add('slug', null, ['label' => 'Slug personnalisé?', 'required' => false])
			->add('urlImage', null, ['label' => 'Chemin de l\'image ?', 'required' => false])
			->add('author', null, ['label' => 'Auteur :'])
			->add('description', null, ['label' => 'Desciption :'])
			->add('datePublication', DateType::class , ['label' => 'Date de publication :', 'widget' => 'text', 'format' => 'd M y'])
			->add('categories', EntityType::class, [
				'class' => Category::class,
				'choice_label' => 'name',
				'expanded' => true, 'multiple' => true,
				'label' => 'Associer des categories'])
			->add('save', SubmitType::class, ['label' => 'Enregistrer', 
				'attr' => ['class' => 'btn btn-success']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_book';
    }


}
