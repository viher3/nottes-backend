<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use PHPUnit\Framework\TestCase;
	use App\Tests\AuthenticationHelper;

	class CalculatorTest extends TestCase
	{
	    public function testAdd()
	    {
	        $authToken = ( new AuthenticationHelper() ) ->getAuthToken();

	        
	    }
	}