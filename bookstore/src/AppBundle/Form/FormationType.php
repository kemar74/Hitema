<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Module;
use AppBundle\Entity\Formation;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class FormationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('name', null, ['label' => 'Nom de la formation :'])
			->add('slug', null, ['label' => 'Nom utilisé dans l\'URL :', 'required' => false])
			->add('urlImage', null, ['label' => 'Chemin vers l\'image :', 'required' => false])
			->add('baseline', null, ['label' => 'Baseline de la formation :'])
			->add('modules', EntityType::class, [
				'class' => Module::class,
				'choice_label' => 'name',
				'expanded' => true, 'multiple' => true,
				'label' => 'Associer des modules'])
			->add('save', SubmitType::class, ['label' => 'Enregistrer', 
				'attr' => ['class' => 'btn btn-success']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_formation';
    }


}
