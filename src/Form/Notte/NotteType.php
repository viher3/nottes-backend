<?php

	namespace App\Form\Notte;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;

	class NotteType extends AbstractType
	{
	    public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        $builder
	            ->add('name')
	            ->add('content')
	            ->add('tags')
	            ->add('isEncrypted')
	            ->add('encryptionpwd', TextType::class, [
					"mapped" => false	            	
	            ])
	            ->add('encryptionpwd2', TextType::class, [
					"mapped" => false	            	
	            ])
	        ;
	    }
	}