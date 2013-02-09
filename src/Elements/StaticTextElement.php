<?php

	namespace MindReports\Elements;
	
	class StaticTextElement extends AbstractJasperElement {
		
		protected $width = 0;
		protected $height = 0;
		
		protected $fontFamily = "Arial";
		protected $fontSize = 10;
		protected $fontStyle = "";
		
		protected $text = "=STATIC_TEXT=";
		
		protected function parseInfo() {
			
			$elementProp = $this->elementInfo->reportElement->attributes();
			
			$this->width	= (int) (string) $elementProp['width'];
			$this->height	= (int) (string) $elementProp['height'];
			
			$this->parseText();
			
			$this->x = ((int) (string) $elementProp['x']) + $this->pageInfo->get('leftMargin');
			$this->y = ((int) (string) $elementProp['y']) + $this->pageInfo->get('topMargin');
			
			return $this;
			
		}
		
		protected function parseText() {
			$this->text	= utf8_decode((string) $this->elementInfo->text);
		}
		
		protected function parseFont() {
			
			if(isset($this->elementInfo->textElement->font)) {
				
				$font = $this->elementInfo->textElement->font;
				$fontAttr = $font->attributes();
				
				if(isset($font['size'])) {
					$this->fontSize = (int) (string) $font['size'];
				}
				
				if(isset($font['isBold']) && $font['isBold'] == 'true') {
					$this->fontStyle .= "B";
				}
				
			}
			
			return $this;
			
		}
		
		
	    public function append($page) {
	    	
	    	$this->parseInfo()->parseFont();
	    	$page->setXY($this->x, $this->y);
	    	
	        $page->SetFont($this->fontFamily, $this->fontStyle, $this->fontSize);
	        
	        $page->Cell($this->width, $this->height, $this->text);
	        
	        return $page;
	        
	    }
	    
	}