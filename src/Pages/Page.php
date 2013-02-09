<?php

	namespace MindReports\Pages;
	
	use fpdf\FPDF;
		
	class Page extends FPDF {
		
		protected $header = null;
		protected $footer = null;
		protected $config = null;
		
		protected $mindPageX = 0;
		protected $mindPageY = 0;
		
		public function __construct($config) {
			parent::__construct('P', 'pt', 'A4');
			$this->config = $config;
		}
		
		public function AddPage($orientation = '', $size = '') {
			parent::AddPage();
			$this->Header();
			$this->mindPageY = $this->config->get('topMargin');
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
		
		public function setXY($x, $y) {
			
			$x += ($x < $this->mindPageX) ? $this->mindPageX : 0;
			$y += ($y < $this->getUsed()) ? $this->getUsed() : 0;
			
			parent::SetXY($x, $y);
			
		}
		
		public function setPageX($x){
			$this->mindPageX = $x;
		}
		
		public function setPageY($y){
			$this->mindPageY = $y;
		}
		
		public function setUsed($used) {
			$this->mindPageY += $used;
		}

		public function getUsed() {
			return ($this->mindPageY == $this->config->get('topMargin')) ? 0 : $this->mindPageY;
		}
		

	}