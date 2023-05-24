<?php
class parse{

	function BBparse($source, $preview = false){
		global $config;

		if(stripos($source, "[link]") !== false){
			$source = preg_replace("#\\[link\\](.*?)\\[/link\\]#ies", "\$this->BBlink('\\1')", $source);
		}
		
		return $source;
		
	}		
	
	function BBlink($source){
		$exp = explode('|', $source);
		
		if($exp[0]){
			if(!$exp[1])
				$exp[1] = $exp[0];

			$source = "<!--link:{$source}--><a href=\"{$exp[0]}\" target=\"_blank\">{$exp[1]}</a><!--/link-->";
		}
		
		return $source;
	}
	
	function BBdecode($source){

		if(stripos($source, "<!--link:") !== false){
			$source = preg_replace("#\\<!--link:(.*?)\\<!--/link-->#ies", "\$this->BBdecodeLink('\\1')", $source);
		}
		
		return $source;
	
	}
	
	function BBdecodeLink($source){
		$start = explode('-->', $source);
		$source = "[link]{$start[0]}[/link]";
		return $source;
	}

}
?>