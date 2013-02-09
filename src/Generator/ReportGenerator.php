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
	    
	    protected function appendTextField($textField) {
	    	$textFieldObject = new TextFieldElement($this->databaseData);
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