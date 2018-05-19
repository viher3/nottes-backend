<?php

	namespace App\Services\Editor;

	class BBCodeCompiler
	{
		private $content;
		private $html;

		public function __construct($bbcodeContent)
		{
			$this->content 	= $bbcodeContent;
			$this->html 	= "";
		}

		public function toHtml()
		{
			$this->transformToHtml();
			return $this->getHtml();
		}

		public function getHtml()
		{
			return $this->html;
		}

		private function transformToHtml()
		{
			// replacements
			$replacements = [
				["\n", '<br />'],
				['[italic]', '<i>'],
				['[/italic]', '</i>'],
				['[hr]', '<hr />'],
				['[bold]', '<strong>'],
				['[/bold]', '</strong>'],
				['[underline]', '<u>'],
				['[/underline]', '</u>'],
			];

			// search with regex
			$regex = [
				['image', '\[image\](.)*?\[\/image\]']
			];

			// process
			foreach($replacements as $rep)
			{
				$this->content = str_replace($rep[0], $rep[1], $this->content);
			}

			foreach($regex as $reg)
			{
				$code = $reg[0];
				preg_match('/' . $reg[1] . '/', $this->content, $matches);

				if($code == "image") $this->generateImage($matches);
			}

			$this->html = $this->content;
		}

		private function generateImage($matches)
		{
			if( empty($matches[0]) && empty($matches[1]) ) return;

			$full 	= $matches[0];
			$url 	= str_replace(array("[image]","[/image]"), "", $full);

			$html = '<img src="' . $url . '" />';

			$this->content = str_replace($full, $html, $this->content);
		} 
	}