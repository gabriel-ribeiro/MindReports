<?php

	namespace MindReports\Elements;

	interface JasperElementInterface {
	    public function setPageInfo($info);
	    public function setElementInfo($info);
	    public function append($page);
	}