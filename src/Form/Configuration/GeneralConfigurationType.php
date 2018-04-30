<?php

	namespace App\Form\Configuration;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;

	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;

	use Symfony\Component\Validator\Constraints\NotBlank;
	use Symfony\Component\Validator\Constraints\Email;

	class GeneralConfigurationType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        $builder
	            ->add("nickname", TextType::class, [
	            	'constraints' => [
           				new NotBlank()
           			]
	            ])
	            ->add("email", EmailType::class, [
	            	'constraints' => [
           				new NotBlank(),
           				new Email()
           			]
	            ])
	            ->add("language", TextType::class, [
	            	'constraints' => [
           				new NotBlank()
           			]
	            ])
	            ->add("password", TextType::class, [
					"mapped" => false,
					'constraints' => [
           				new NotBlank()
           			]	            	
	            ])
	        ;
	    }
	}