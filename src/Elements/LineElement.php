<?php

	namespace MindReports\Elements;
	
	class LineElement extends AbstractJasperElement{
		
		protected $xStart, $yStart;
		protected $xEnd, $yEnd;
		
		public function append($page) {

			$attr = $this->elementInfo->reportElement->attributes();
			
			$this->xStart = ((int) (string) $attr['x']) + $this->pageInfo->get('leftMargin');
			$this->yStart = ((int) (string) $attr['y']) + $this->pageInfo->get('topMargin');
			
			$width = (int) (string) $attr['width'];
			$height = (int) (string) $attr['height'];
			
			$this->xEnd = ($this->xStart + $width) - 1;
			$this->yEnd = ($this->yStart + $height) - 1;
			
			$page->Line($this->xStart, $this->yStart + $page->getUsed(), $this->xEnd, $this->yEnd + $page->getUsed());
			
			return $page;
			
		}
		

		
	}