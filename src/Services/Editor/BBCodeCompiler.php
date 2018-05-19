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
				['image', '\[image\](.*?)\[\/image\]']
			];

			// process
			foreach($replacements as $rep)
			{
				$this->content = str_replace($rep[0], $rep[1], $this->content);
			}

			foreach($regex as $reg)
			{
				$code = $reg[0];
				preg_match_all('/' . $reg[1] . '/', $this->content, $matches);

				if($code == "image") $this->generateImages($matches);
			}
			$this->html = $this->content;
		}

		private function generateImages($matches)
		{
			if( empty($matches[1]) ) return;

			foreach($matches[1] as $key => $imageUrl)
			{
				$html = '<img src="' . $imageUrl . '" />';
				$this->content = str_replace($matches[0][$key], $html, $this->content);
			}

		} 
	}