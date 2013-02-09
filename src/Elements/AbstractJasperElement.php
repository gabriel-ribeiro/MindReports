<?php

	namespace MindReports\Elements;
	
	abstract class AbstractJasperElement implements JasperElementInterface {
	    
	    protected $pageInfo = null;
	    protected $elementInfo = null;
	    
	    public function setPageInfo($info) {
	    	$this->pageInfo = $info;
	    }
	    
	    public function setElementInfo($info) {
	    	$this->elementInfo = $info;
	    }
	    
	}