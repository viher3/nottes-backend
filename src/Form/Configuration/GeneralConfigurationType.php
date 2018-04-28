<?php

	namespace App\Form\Configuration;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;

	class GeneralConfigurationType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        $builder
	            ->add("nickname", TextType::class, [
	            	"required" => true
	            ])
	            ->add("email", EmailType::class, [
	            	"required" => true
	            ])
	            ->add("language", TextType::class, [
	            	"required" => true
	            ])
	            ->add("password", TextType::class, [
					"mapped" => false	            	
	            ])
	        ;
	    }
	}