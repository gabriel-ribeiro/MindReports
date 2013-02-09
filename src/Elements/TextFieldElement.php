<?php

	namespace MindReports\Elements;
	
	class TextFieldElement extends StaticTextElement {
		
		private $data = array();
		
		public function __construct($data) {
			$this->data = $data;
		}
		
		protected function parseText() {
			
			$expression	= utf8_decode((string) $this->elementInfo->textFieldExpression);
			$field = $this->getField($expression);
			
			$this->text = isset($this->data[0][$field]) ? $this->data[0][$field] : '-not found-';
			
		}
		
		private function getField($expression) {
			
			$expression = trim($expression);
			$length = strlen($expression);
			
			$expression = substr($expression, 3, $length - 3);
			$field = substr($expression, 0, strlen($expression) - 1);
			
			return $field;
			
		}
		
	}