<?php

	namespace MindReports\Elements;
	
	use MindReports\Pages\Page;
	class ImageElement extends AbstractJasperElement {
		
		private $data = array();
		
		public function __construct($data) {
			$this->data = $data;
		}
		
	
		public function append($page) {
			
			$expr = (string) $this->elementInfo->imageExpression;
			$field = $this->getParameter($expr);
			
			if($this->expressionType($expr) == 'P') {
				$value = ($this->pageInfo->getParameter($field) != null) ? $this->pageInfo->getParameter($field) : '-not found-';
			} elseif($this->expressionType($expr) == 'F') {
				$value = (isset($this->data[0][$field])) ? $this->data[$field] : '-not found-';
			} else {
				$value = substr($expr, 1, strlen($expr) - 2);
			}
			
			$page instanceof Page;
			
			$x = ((int) (string) $this->elementInfo->reportElement->attributes()['x']) + $this->pageInfo->get('leftMargin');
			$y = ((int) (string) $this->elementInfo->reportElement->attributes()['y']) + $this->pageInfo->get('topMargin');

			$w = (int) (string) $this->elementInfo->reportElement->attributes()['width'];
			$h = (int) (string) $this->elementInfo->reportElement->attributes()['height'];
			
			$page->Image($value, $x, $y, $w, $h);
			
			return $page;
		
		}
		
		private function getParameter($expression) {
				
			$expression = trim($expression);
			$length = strlen($expression);
				
			$expression = substr($expression, 3, $length - 3);
			$field = substr($expression, 0, strlen($expression) - 1);
				
			return $field;
				
		}
		
		private function expressionType($expr) {
			$type = substr(trim($expr), 1, 1);
			return strtoupper($type);
		}
		
	}