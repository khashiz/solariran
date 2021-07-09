<?php
/**
* @package RSSeo!
* @copyright (C) 2019 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

class RSOptimizerJS extends RSOptimizer
{
	protected $queue		= array();
	protected $excluded		= array();
		
	// Main optimization function for stylesheets
	public function optimize(&$content) {
		$minify_js 	 	 = $this->params->get('minify_js', 0);
		$merge_inline_js = $this->params->get('merge_inline_js', 0);
		
		// Greab only the head section
		$head_content = '';
		if ( $minify_js || $merge_inline_js ) {
			if (preg_match('#<head>([\s\S]*)<\/head>#i', $content, $match)) {
				$head_content = $match[1];
			}
		}
		
		// Minify the available JS files if the option is active
		if ($minify_js) {
			if (!empty($head_content) && preg_match_all('#(\n)?<script(.*)><\/script>(\n)?#i', $head_content, $matches)) {
				foreach ($matches[0] as $i => $fullmatch) {
					if (preg_match('#src="(.*?)"#i', $fullmatch, $match)) {
						$url = html_entity_decode($match[1]);
						if ($this->isInternal($url)) {
							if (!$this->isFileExcluded($url) && ($file = $this->getAbsolutePath($url))) {
								$reference = 'all';
								if (!$this->params->get('merge_all_js', 0)) {
									$type = 'other';
									if (preg_match('#templates|system|media|components|plugins|modules#i', $file, $match)) {
										$type = strtolower($match[0]);
									}
									$reference = $type; 
								}
								$this->queue[$reference][$fullmatch] = $file;
							}
							
							// Get all excluded files
							if ($this->isFileExcluded($url)) {
								$this->excluded[] = trim($fullmatch);
							}
						}
					}
				}
			}
			
			// If there are files in the queue and the cache has been built successfully, go on with replacing the content
			if ($this->queue && $this->buildCache()) {
				// Strip all JS found
				foreach ($this->queue as $queue) {
					$content = str_replace(array_keys($queue), '', $content);
				}
				
				$minifiedJSFiles = array();
				foreach ($this->queue as $reference => $queue) {
					if ($this->params->get('gzip', 0)) {
						$minifiedJSFiles[] = '<script src="'.$this->root.'/index.php?rsogzip='.$this->getCachedFile($reference).'" type="text/javascript"></script>';
					} else {
						$minifiedJSFiles[] = '<script src="'.$this->root.'/cache/plg_system_rsseo/'.$this->getCachedFile($reference).'" type="text/javascript"></script>';
					}
				}
				
				if (!empty($this->excluded)) {
					$content = str_replace($this->excluded, '', $content);
					$minifiedJSFiles = array_merge($minifiedJSFiles, $this->excluded);
				}
				
				// Add our own js files			
				$content = str_replace('</head>', "\r\n".implode("\r\n", $minifiedJSFiles).'</head>', $content);
			}
		}
		
		// Minify the inline script if the option is active
		if (($minify_js || $merge_inline_js) && !empty($head_content)) {
			// Grab inline scripts
			$inline_js	= array();
			$remove 	= array();
			
			if (preg_match_all('#<script.*?>(.*?)<\/script>\s+?#is', $head_content, $matches)) {
				foreach ($matches[0] as $i => $fullmatch) {
					$matches[1][$i] = trim($matches[1][$i]);
					if (!empty($matches[1][$i])) {
						// This needs to be left alone
						if (strpos($fullmatch, 'joomla-script-options') !== false) {
							continue;
						}
						
						preg_match('#type="(.*?)"#', $matches[0][$i], $typeMatch);
						$type = isset($typeMatch[1]) ? $typeMatch[1] : 'text/javascript';
						
						$remove[]			= $fullmatch;
						$inline_js[$type][]	= ($merge_inline_js ? $this->minifyContent($matches[1][$i]) : $matches[1][$i]); 
					}
				}
			}
			
			// If there are inline javascript then put them before the tag head is closed
			if ($inline_js) {
				// Strip all inline styles found
				$content = str_replace($remove, '', $content);
				
				// Add the new minified styles
				$scripts = array();
				
				foreach ($inline_js as $type => $scriptData) {
					if ($type == 'application/ld+json') {
						$scripts[] = '<script type="'.$type.'">['.implode(',', $scriptData).']</script>';
					} else {
						$scripts[] = '<script type="'.$type.'">'.implode("\r\n", $scriptData).'</script>';
					}
				}
				
				$content = str_replace('</head>', "\r\n".implode("\r\n", $scripts)."\r\n".'</head>', $content);
			}
		}
	}
	
	// Method to read the contents of the file (for caching) and apply fixes.
	public function readFile($path) {
		$buffer = parent::readFile($path);
		$buffer = $this->minifyContent($buffer);
		$path	= str_replace(array(JPATH_SITE.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR), array('','/'), $path);
		
		// Check for the semicolon at the end of the script
		$semicolon = substr($buffer, -1);
		if ($semicolon != ';') {
			$buffer .=';';
		}
		
		if ($this->params->get('try_catch', 0)) {
			$buffer = "try{".$buffer."}catch(e){ console.error('Error on file: $path (' + e.message + ');');}";
		}
		
		return "/* @original $path */\r\n".$buffer;
	}
	
	// We need to return a .css extension file
	public function getCachedFile($reference) {
		return $this->getHash($reference).'.js';
	}
	
	// We need to minify the output of the file before we store it to the cached file
	public function minifyContent($content) {
		require_once dirname(__FILE__).'/minifier.php';
		
		try {
			return Minifier::minify($content);
		} catch (Exception $e) {
			return $content;
		}
	}
}