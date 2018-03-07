<?php

	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;

	class NotteType extends AbstractType
	{
	    public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        $builder
	            ->add('name')
	            ->add('content')
	            ->add('tags')
	            ->add('isEncrypted')
	            ->add('creatorUser')
	        ;
	    }
	}