<?php

	namespace App\Services\Upload;

	class FileSanitizer
	{
		public function sanitize($value)
		{
			$value = strtolower($value);
			$value = str_replace( array(" ", "-"), "_", $value);
			$value = str_replace( "ñ", "n", $value);
			$value = filter_var($value, FILTER_SANITIZE_STRING);
			$value = preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $value);
			$value = trim($value);

			return uniqid() . "_" . $value;
		}
	}