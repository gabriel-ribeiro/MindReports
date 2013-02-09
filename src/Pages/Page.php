<?php

	namespace MindReports\Pages;
	
	use fpdf\FPDF;
		
	class Page extends FPDF {
		
		protected $header = null;
		protected $footer = null;
		protected $config = null;
		
		public function __construct() {
			parent::__construct('P', 'pt', 'A4');
		}
		
		public function header() {
			parent::Header();
			
			if(is_callable($this->header))
				$this->header();
			
		}
		
		public function footer() {
			parent::Footer();

			if(is_callable($this->footer))
				$this->footer();
			
		}
		
		public function setHeader($callback) {
			$this->header = $callback;
		}
		
		public function setFooter($callback) {
			$this->footer = $callback;
		}

	}