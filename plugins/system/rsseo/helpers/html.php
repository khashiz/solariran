<?php
/**
* @package RSSeo!
* @copyright (C) 2019 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

class RSOptimizerHTML extends RSOptimizer
{
	public function optimize(&$content) {
		// Compress the final HTML if the option is active
		$chunks		= preg_split('/(<pre.*?\/pre>)/ms', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
		$content	= '';
		
		$replace = array(
			'#[\n\r\t\s]+#'           => ' ',  // remove new lines & tabs
			'#>\s{2,}<#'              => '><', // remove inter-tag whitespace
			'#\/\*.*?\*\/#i'          => '',   // remove CSS & JS comments
			'#<!--(?![\[>]).*?-->#si' => '',   // strip comments, but leave IF IE (<!--[...]) and "<!-->""
			'#\s+<(html|head|meta|style|/style|title|script|/script|/body|/html|/ul|/ol|li)#' => '<$1', // before those elements, whitespace is dumb, so kick it out!!
			'#\s+(/?)>#' => '$1>', // just before the closing of " >"|" />"
			'#class="\s+#'=> 'class="', // at times, there is whitespace before class=" className"
			'#(script|style)>\s+#' => '$1>', // <script> var after_tag_has_whitespace = 'nonsens';
		);
		
		$search = array_keys($replace);
		foreach ($chunks as $chunk) {
			if (strpos($chunk, '<pre') !== 0) {
				$chunk = preg_replace($search, $replace, $chunk);
			}
			
			$content .= $chunk;
		}
	}
}