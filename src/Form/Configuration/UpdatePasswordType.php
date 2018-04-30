<?php

	namespace App\Form\Configuration;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;

	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;

	use Symfony\Component\Validator\Constraints\NotBlank;

	class UpdatePasswordType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        $builder
	            ->add("currentPassword", TextType::class, [
					"mapped" => false,
					'constraints' => [
           				new NotBlank()
           			]	            	
	            ])
	            ->add("newPassword", TextType::class, [
					"mapped" => false,
					'constraints' => [
           				new NotBlank()
           			]	            	
	            ])
	        ;
	    }
	}