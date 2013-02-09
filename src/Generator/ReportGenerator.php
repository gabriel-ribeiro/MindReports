<?php

	namespace MindReports\Generator;
	
	use MindReports\Elements\StaticTextElement;
use MindReports\Elements\TextFieldElement;
use MindReports\Elements\LineElement;
use MindReports\Elements\ImageElement;
				
	class ReportGenerator {
	    
	    /**
	     * Configurações do relatorio
	     * @var \MindReports\Parser\JasperXMLParser
	     */
	    private $configuration;
	    
	    /**
	     * Coordenadas atuais
	     * @var integer
	     */
	    private $x = 0, $y = 0;
	    
	    /**
	     * Objeto da pagina
	     * @var \MindReports\Pages\Page
	     */
	    private $page = null;
	    
	    /**
	     * Database data
	     * @var array
	     */
	    private $databaseData = array();
	    
	    public function __construct(\MindReports\Parser\JasperXMLParser $config, $page) {
	        $this->configuration = $config;
	        $this->setPage($page);
	    }

	    public function setDatabaseData($data) {
	    	$this->databaseData = (array) $data;
	    }
	    
	    public function setPage($page) {
	    	$this->page = $page;
	    }
	    
	    public function generate() {
			$this->page->AddPage();
			$this->generateHead();
			$this->generateColumnHeader();

			$index = 0;
			foreach($this->databaseData as $row) {
				$this->generateDetail($index);
				$index++;
			}
	    	
	    }
	    
	    protected function generateHead() {
	    	
	        $titleNode = $this->configuration->get('xmlObject')->title;
	        $titleBand = $titleNode->band;
	        
	        foreach($titleBand->staticText as $staticText) {
	        	$this->appendStaticText($staticText);
	        }

	        foreach($titleBand->textField as $textField) {
	        	$this->appendTextField($textField);
	        }

	        foreach($titleBand->line as $line) {
	        	$this->appendLine($line);
	        }

	        foreach($titleBand->image as $image) {
	        	$this->appendImage($image);
	        }
	        
	        $this->page->setUsed((int) (string) $titleNode->band->attributes()['height']);
	        
	    }

	    protected function generateColumnHeader() {
	    	
	        $columnHeaderNode = $this->configuration->get('xmlObject')->columnHeader;
	        $columnHeaderBand = $columnHeaderNode->band;
	        
	        foreach($columnHeaderBand->staticText as $staticText) {
	        	$this->appendStaticText($staticText);
	        }

	        foreach($columnHeaderBand->textField as $textField) {
	        	$this->appendTextField($textField);
	        }

	        foreach($columnHeaderBand->line as $line) {
	        	$this->appendLine($line);
	        }

	        foreach($columnHeaderBand->image as $image) {
	        	$this->appendImage($image);
	        }
	        
	        $this->page->setUsed((int) (string) $columnHeaderNode->band->attributes()['height']);

	    }

	    protected function generateDetail($index = 0) {
	    	
	        $detailNode = $this->configuration->get('xmlObject')->detail;
	        $detailBand = $detailNode->band;
	        
	        foreach($detailBand->staticText as $staticText) {
	        	$this->appendStaticText($staticText);
	        }

	        foreach($detailBand->textField as $textField) {
	        	$this->appendTextField($textField, $index);
	        }

	        foreach($detailBand->line as $line) {
	        	$this->appendLine($line);
	        }

	        foreach($detailBand->image as $image) {
	        	$this->appendImage($image);
	        }
	        
	        $this->page->setUsed((int) (string) $detailNode->band->attributes()['height']);

	    }
	    
	    public function getPage() {
	    	return $this->page;
	    }
	    
	    protected function appendStaticText($staticText) {
	    	$staticTextObject = new StaticTextElement();
	    	$staticTextObject->setElementInfo($staticText);
	    	$staticTextObject->setPageInfo($this->configuration);
	    	$pagina = $staticTextObject->append($this->page);
	    	$this->page = $pagina;
	    }
	    
	    protected function appendTextField($textField, $index = 0) {
	    	$textFieldObject = new TextFieldElement($this->databaseData, $index);
	    	$textFieldObject->setElementInfo($textField);
	    	$textFieldObject->setPageInfo($this->configuration);
	    	$pagina = $textFieldObject->append($this->page);
	    	$this->page = $pagina;
	    }
	    
	    protected function appendLine($line) {
	    	$lineObject = new LineElement();
	    	$lineObject->setElementInfo($line);
	    	$lineObject->setPageInfo($this->configuration);
	    	$pagina = $lineObject->append($this->page);
	    	$this->page = $pagina;
	    }
	    
	    protected function appendImage($image) {
	    	$imageObject = new ImageElement($this->databaseData);
	    	$imageObject->setElementInfo($image);
	    	$imageObject->setPageInfo($this->configuration);
	    	$pagina = $imageObject->append($this->page);
	    	$this->page = $pagina;
	    }
	    
	}