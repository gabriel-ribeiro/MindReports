<?php

	namespace MindReports\Parser;
	
	/**
	 * Interpretador do XML gerado pelo iReports
	 * @author	Gabriel Ribeiro Araujo <ribeirogabriel.95@gmail.com>
	 */
	class JasperXMLParser {
		
		private $xmlFile = "";
		private $xmlObject = null;
		
		/**
		 * Left Margin - Page property
		 * @var integer|null
		 */
		private $leftMargin = null;
		
		/**
		 * Top Margin - Page property
		 * @var integer|null
		 */
		private $topMargin = null;
		
		/**
		 * Right Margin - Page property
		 * @var integer|null
		 */
		private $rightMargin = null;
		
		/**
		 * Parametros
		 * @var array
		 */
		private $parameters = array();
		
		
		/**
		 * Construtor
		 * @param string $file Caminho completo para o arquivo
		 */
		public function __construct($file = "") {
			$this->setFile($file);
		}
		
		public function addParameter($param, $value) {
			$this->parameters[$param] = $value;
			return $this;
		}
		
		/**
		 * Set File - Define o arquivo que será carregado para o interpretador
		 * @param string $filename Caminho completo do arquivo
		 * @throws \Exception Caso o arquivo não seja encontrado
		 * @return \MindReports\Parser\JasperXMLParser
		 */
		public function setFile($filename) {
			
			if(file_exists($filename)) {
				$this->xmlFile = $filename;
				$this->xmlObject = simplexml_load_file($this->xmlFile);
				$this->parse();
			} else {
				throw new \Exception("File not found");
			}
			
			return $this;
			
		}
		
		private function parse() {
		    $this->leftMargin	= (int) (string) $this->xmlObject->attributes()['leftMargin'];
		    $this->topMargin	= (int) (string) $this->xmlObject->attributes()['topMargin'];
		    $this->rightMargin	= (int) (string) $this->xmlObject->attributes()['rightMargin'];
		}
		
		public function get($property) {
		    return $this->$property;
		}

		public function set($property, $value) {
		    $this->$property = $value;
		}
		
		public function getQuery() {
			$queryString = trim((string) $this->xmlObject->queryString);
			return $this->injectParams($queryString);
		}
		
		public function injectParams($string) {
			
			$paramsList = array();
			
			foreach($this->parameters as $param => $value) {
				$param = '$P{' . $param . '}';
				$paramsList[$param] = $value;
			}
			
			return str_replace(array_keys($paramsList), array_values($paramsList), $string);
			
		}
		
		public function getParameter($parameter) {
			return (isset($this->parameters[$parameter])) ? $this->parameters[$parameter] : null;
		}
		
	}