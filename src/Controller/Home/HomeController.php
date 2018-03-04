<?php

	namespace App\Controller\Home;

	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;

	class HomeController extends Controller
	{
		public function index()
		{
			return new JsonResponse("Nottes api!");
		}
	}