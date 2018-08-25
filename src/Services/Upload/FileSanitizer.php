<?php

	namespace App\Services\Upload;

	/** 
	 * Sanitizes a file name string.
	 * 
	 * @author alberto@albertolabs.com
	 */
	class FileSanitizer
	{	
		/**
		 * Sanitizes a string
		 *
		 * @param 	String 	$value 		Filename string
		 * @return 	String 	$value 		Sanitized filename string
		 */
		public function sanitize($value)
		{
			// Convert to lowercase
			$value = strtolower($value);

			// Remove non alphanumeric characters
			$value = preg_replace("/[^a-z0-9\_\-\.]/i", '', $value);

			// Replace rules
			$value = str_replace("ñ", "n", $value);
			$value = str_replace(array(" ", "-"), "_", $value);
			$value = trim($value);

			return $value;
		}
	}