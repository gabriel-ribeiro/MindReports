<?php

	namespace MindReports\Generator;
	
	use MindReports\Pages\Page,
		MindReports\Parser\JasperXMLParser;
			
	class PageGenerator {
		
	    public static function generatePage(JasperXMLParser $parser) {
	    
	    	$page = new Page($parser);
	    
	    	$leftMargin		= (int) (string) $parser->get('leftMargin');
	    	$topMargin		= (int) (string) $parser->get('topMargin');
	    	$rightMargin	= (int) (string) $parser->get('rightMargin');
	    
	    	$page->SetMargins($leftMargin, $topMargin, $rightMargin);
	    	$page->SetFont('Arial', '', 13);
	    	$page->setPageX($leftMargin);
	    	$page->setPageY($topMargin);
	    	
	    	return $page;

	    }
	    
	}