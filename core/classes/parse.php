<?php
/* 
	Appointment: ������� ������
	File: parse.php 
 
*/

class parse{

	function BBparse($source, $preview = false){
		global $config;

		$source = preg_replace("#<iframe#i", "&lt;iframe", $source);
		$source = preg_replace("#<script#i", "&lt;script", $source);
		
		$source = str_ireplace("{", "&#123;", $source);
		$source = str_ireplace("`", "&#96;", $source);
		$source = str_ireplace("{theme}", "&#123;theme}", $source);
		
		$source = str_ireplace("[b]", "<b>", str_ireplace("[/b]", "</b>", $source));
		$source = str_ireplace("[i]", "<i>", str_ireplace("[/i]", "</i>", $source));
		$source = str_ireplace("[u]", "<u>", str_ireplace("[/u]", "</u>", $source));
		$source = str_ireplace("[ol]", "<ol>", str_ireplace("[/ol]", "</ol>", $source));
		$source = str_ireplace("[ul]", "<ul class=\"listing2\">", str_ireplace("[/ul]", "</ul>", $source));
		$source = str_ireplace("[li]", "<li><span>", str_ireplace("[/li]", "</span></li>", $source));
		$source = str_ireplace("[s]", "<s>", str_ireplace("[/s]", "</s>", $source));
		
		$source = preg_replace("#\[(left|right|center)\](.+?)\[/\\1\]#is", "<div align=\"\\1\">\\2</div>", $source);
		
		$source = preg_replace( "#\[quote\](.+?)\[/quote\]#is", "<blockquote>\\1</blockquote>", $source );
		
		if(stripos($source, "[video]") !== false || stripos($source, "[photo]") !== false || stripos($source, "[phl]") !== false || stripos($source, "[link]") !== false || stripos($source, "[color]") !== false){
			$source = preg_replace("#\\[video\\](.*?)\\[/video\\]#ies", "\$this->BBvideo('\\1', '{$preview}')", $source);
			$source = preg_replace("#\\[photo\\](.*?)\\[/photo\\]#ies", "\$this->BBphoto('\\1', '{$preview}')", $source);
			$source = preg_replace("#\\[phl\\](.*?)\\[/phl\\]#ies", "\$this->BBphl('\\1', '{$preview}')", $source);
			$source = preg_replace("#\\[link\\](.*?)\\[/link\\]#ies", "\$this->BBlink('\\1')", $source);
			$source = preg_replace("#\\[color\\](.*?)\\[/color\\]#ies", "\$this->BBcolor('\\1')", $source);
		}
		
		return $source;
		
	}
	
	function BBvideo($source, $preview = false){
		global $config;
		
		$exp = explode('|', $source);
		$home_url = $config['home_url'];

		if(stripos($source, "{$exp[0]}|{$exp[1]}|{$home_url}") !== false){
			
			if($exp[3])
				if($exp[3] > 175)
					$width = "width=\'175\'";
				else
					$width = "width=\'{$exp[3]}\'";
					
			if($exp[4])
				if($exp[4] > 131)
					$height = "height=\'131\'";
				else
					$height = "height=\'{$exp[4]}\'";
			
			if($exp[5])
				$border = 'notes_videoborder';
				
			if($exp[6])
				$blank = 'target="_blank"';
			else
				$blank = "onClick=\"videos.show({$exp[1]}, this.href, \'/notes/view/{note-id}\'); return false\"";
			
			if($exp[7] == 1)
				$pos = "align=\"left\"";
			elseif($exp[7] == 2)
				$pos = "align=\"right\"";
			else
				$pos = "";
			
			if(!$preview){
				$link = "<a href=\"/video{$exp[0]}_{$exp[1]}_sec=notes/id={note-id}\" {$blank}>";
				$slink = "</a>";
			}

			$source = "<!--video:{$source}-->{$link}<img src=\"{$exp[2]}\" {$width} {$height} {$pos} class=\"notes_videopad {$border}\" />{$slink}<!--/video-->";
		}
		
		return $source;
	}
	
	function BBphoto($source, $preview = false){
		global $config;
		
		$exp = explode('|', $source);
		$home_url = $config['home_url'];

		if(stripos($source, "{$exp[0]}|{$exp[1]}|{$home_url}") !== false){
			
			if($exp[3] > 160)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[4] > 120)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[3])
				if($exp[3] > 740)
					$width = "width=\'740\'";
				else
					$width = "width=\'{$exp[3]}\'";
					
			if($exp[4])
				if($exp[4] > 547)
					$height = "height=\'547\'";
				else
					$height = "height=\'{$exp[4]}\'";
			
			if($exp[5])
				$border = 'notes_videoborder';
				
			if($exp[6])
				$blank = 'target="_blank"';
			else
				$blank = "onClick=\"Photo.Show(this.href); return false\"";
			
			if($exp[7] == 1)
				$pos = "align=\"left\"";
			elseif($exp[7] == 2)
				$pos = "align=\"right\"";
			else
				$pos = "";
				
			if($exp[8] AND !$preview AND $exp[0] AND $exp[1]){
				$link = "<a href=\"/photo{$exp[0]}_{$exp[1]}_sec=notes/id={note-id}\" {$blank}>";
				$elink = "</a>";
			} elseif($exp[8]) {
				$link = "<a href=\"{$exp[2]}\" target=\"_blank\">";
				$elink = "</a>";
			} else {
				$link = '';
				$elink = '';
			}
			
			if($exp[0] AND $exp[1])
				$source = "<!--photo:{$source}-->{$link}<img class=\"notes_videopad {$border}\" src=\"{$exp[2]}\" {$width} {$height} {$pos} />{$elink}<!--/photo-->";
			else
				$source = "<!--photo:{$source}-->{$link}<img class=\"notes_videopad {$border}\" src=\"{$exp[2]}\" {$width} {$height} {$pos} />{$elink}<!--/photo-->";
		}
		
		return $source;
	}
	
	function BBphl($source, $preview = false){
		global $config;
		$exp = explode('|', $source);
		$home_url = $config['home_url'];
		
		if($exp[0]){
			if(!$exp[1])
				$exp[1] = $exp[0];
			if($exp[3] > 160)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[4] > 120)
				$exp[2] = str_replace('/c_', '/', $exp[2]);
				
			if($exp[3])
				if($exp[3] > 740)
					$width = "width=\'740\'";
				else
					$width = "width=\'{$exp[3]}\'";
					
			if($exp[4])
				if($exp[4] > 547)
					$height = "height=\'547\'";
				else
					$height = "height=\'{$exp[4]}\'";
			
			if($exp[5])
				$border = 'notes_videoborder';
			
			if($exp[6] == 1)
				$pos = "align=\"left\"";
			elseif($exp[6] == 2)
				$pos = "align=\"right\"";
			else
				$pos = "";

			$source = "<!--phl:{$source}--><a href=\"{$exp[0]}\" target=\"_blank\"><img class=\"notes_videopad {$border}\" src=\"{$exp[1]}\" {$width} {$height} {$pos} /></a><!--/phl-->";
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
	
	function BBcolor($source){
		$exp = explode('|', $source);
		
		if($exp[0]){
			if(!$exp[1])
				$exp[1] = $exp[0];

			$source = "<!--color:{$source}--><font color=\"{$exp[0]}\">{$exp[1]}</font><!--/color-->";
		}
		
		return $source;
	}
	
	function BBdecode($source){
	
		$source = str_ireplace("&#123;", "{", $source);
		$source = str_ireplace("&#96;", "`", $source);
		$source = str_ireplace("&#123;theme}", "{theme}", $source);
		
		$source = str_ireplace("<b>", "[b]", str_ireplace("</b>", "[/b]", $source));
		$source = str_ireplace("<i>", "[i]", str_ireplace("</i>", "[/i]", $source));
		$source = str_ireplace("<u>", "[u]", str_ireplace("</u>", "[/u]", $source));
		$source = str_ireplace("<ol>", "[ol]", str_ireplace("</ol>", "[/ol]", $source));
		$source = str_ireplace("<ul class=\"listing2\">", "[ul]", str_ireplace("</ul>", "[/ul]", $source));
		$source = str_ireplace("<li><span>", "[li]", str_ireplace("</span></li>", "[/li]", $source));
		$source = str_ireplace("<s>", "[s]", str_ireplace("</s>", "[/s]", $source));
		
		$source = preg_replace("#<div align=\"(left|right|center)\">(.+?)</div>#is", "[\\1]\\2[/\\1]", $source);
		
		$source = preg_replace( "#\[quote\](.+?)\[/quote\]#is", "<blockquote>\\1</blockquote>", $source );
		
		$source = preg_replace( "#<blockquote>(.+?)</blockquote>#is", "[quote]\\1[/quote]", $source );
		
		if(stripos($source, "<!--photo:") !== false || stripos($source, "<!--phl:") !== false || stripos($source, "<!--video:") !== false || stripos($source, "<!--link:") !== false || stripos($source, "<!--color:") !== false){
			$source = preg_replace("#\\<!--video:(.*?)\\<!--/video-->#ies", "\$this->BBdecodeVideo('\\1')", $source);
			$source = preg_replace("#\\<!--photo:(.*?)\\<!--/photo-->#ies", "\$this->BBdecodePhoto('\\1')", $source);
			$source = preg_replace("#\\<!--phl:(.*?)\\<!--/phl-->#ies", "\$this->BBdecodePhl('\\1')", $source);
			$source = preg_replace("#\\<!--link:(.*?)\\<!--/link-->#ies", "\$this->BBdecodeLink('\\1')", $source);
			$source = preg_replace("#\\<!--color:(.*?)\\<!--/color-->#ies", "\$this->BBdecodeColor('\\1')", $source);
		}
		
		return $source;
	
	}
	
	function BBdecodePhoto($source){
		$start = explode('-->', $source);
		$source = "[photo]{$start[0]}[/photo]";
		return $source;
	}
	
	function BBdecodePhl($source){
		$start = explode('-->', $source);
		$source = "[phl]{$start[0]}[/phl]";
		return $source;
	}
	
	function BBdecodeVideo($source){
		$start = explode('-->', $source);
		$source = "[video]{$start[0]}[/video]";
		return $source;
	}
	
	function BBdecodeLink($source){
		$start = explode('-->', $source);
		$source = "[link]{$start[0]}[/link]";
		return $source;
	}

	function BBdecodeColor($source){
		$start = explode('-->', $source);
		$source = "[color]{$start[0]}[/color]";
		return $source;
	}
	
}
?>