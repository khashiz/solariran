<?php
/**
* @package RSSeo!
* @copyright (C) 2017 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

class RsseoSef extends JRouterSite
{
	protected function getSEF($url) {
		static $sefURLs = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$hash	= md5($url);
		
		if (!isset($sefURLs[$hash])) {
			$query->clear()
				->select($db->qn('sef'))
				->from($db->qn('#__rsseo_pages'))
				->where($db->qn('hash').' = '.$db->q($hash))
				->where($db->qn('published').' = '.$db->q(1));
			$db->setQuery($query);
			$sefURLs[$hash] = (string) $db->loadResult();
		}
		
		return $sefURLs[$hash];
	}
	
	public function buildRule(&$router, &$uri) {
		// Get variables
		$clone		= clone($uri);
		$rewrite	= file_exists(JPATH_SITE.'/.htaccess');
		$lang_codes = JLanguageHelper::getLanguages('lang_code');
		$current	= $uri->getVar('lang');
		$lang_sef 	= JFactory::getApplication()->getLanguageFilter() ? (isset($lang_codes[$current]->sef) ? $lang_codes[$current]->sef : '') : '';
		
		// Create the SEF URL
		$url	= $this->joomlaBuild($clone);
		$found	= $this->getSEF($url);
		
		if (!$found) {
			$newURL = str_replace('&', '&amp;', $url);
			$found	= $this->getSEF($newURL);
		}
		
		if ($found) {
			if (!$rewrite) {
				if ($lang_sef) {
					$found = $lang_sef.'/'.$found;
				}
				
				$found = 'index.php/'.$found;
			}
			
			$newUri		= new JUri($found);
			$newPath	= $newUri->getPath();
			
			if ($rewrite && $lang_sef) {
				$newPath = $lang_sef.'/'.$newPath;
			}
			
			// Remove suffix
			if (JFactory::getConfig()->get('sef_suffix') && substr($newPath,-5) == '.html') {
				$newPath = str_replace('.html','',$newPath);
			}
			
			$newUri->setPath($newPath);
			$uri = $newUri;
			
			return $uri;
		}
		
		return $uri;
	}
	
	public function parseRule(&$router, &$uri) {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		// Get the current URL
		// Let's see if it's a specific URL with query parameters
		$currentURL = $this->buildCurrentUrl($uri, array('path','query'));
		
		if (!empty($currentURL)) {
			$query->clear()
				->select($db->qn('url'))
				->from($db->qn('#__rsseo_pages'))
				->where($db->qn('sef').' = '.$db->q($currentURL));
			$db->setQuery($query);
			$url = $db->loadResult();
			
			// No match, look for URL without query
			if (empty($url)) {
				if ($currentURL = $this->buildCurrentUrl($uri, array('path'))) {
					$query->clear()
						->select($db->qn('url'))
						->from($db->qn('#__rsseo_pages'))
						->where($db->qn('sef').' = '.$db->q($currentURL));
					$db->setQuery($query);
					$url = $db->loadResult();
				}
			}
			
			if ($url) {
				$vars = array();
				
				if (!JFactory::getConfig()->get('sef_rewrite')) {
					$url = str_replace('index.php/','',$url);
				}
				
				if (JFactory::getApplication()->getLanguageFilter()) {
					$parts		= explode('/',$url);
					$lang_codes = JLanguageHelper::getLanguages('lang_code');
					$current	= JFactory::getLanguage()->getTag();
					$lang_sef 	= isset($lang_codes[$current]->sef) ? $lang_codes[$current]->sef : '';
					
					if ($parts[0] == $lang_sef) {
						array_shift($parts);
					}
					
					$url = implode('/', $parts);
				}
				
				if ($this->isJ4()) {
					$newUri = new JUri(JUri::root().$url);
					JRouter::parse($newUri, true);
					
					$uri = $newUri;
				} else {
					$this->setMode(JROUTER_MODE_SEF);
					$originalURI	= new JUri;
					$originalURI->parse($url);
					
					$clone		= clone($originalURI);
					$cloneVars	= $clone->getQuery(true);
					
					$vars += JRouterSite::parseSefRoute($originalURI);
					$vars = array_merge($this->getVars(),$vars, $cloneVars);
					
					if (isset($vars['Itemid'])) {
						$originalURI->setVar('Itemid', $vars['Itemid']);
					}
					
					$uri = $originalURI;
					
					return $vars;
				}
			}
		}
	}
	
	protected function buildCurrentUrl($uri, $parts = array()) {
		$base		= JUri::base(true);
		$currentURL	= $uri->toString($parts);
		
		// Remove base
		if (!empty($base)) {
			if (strpos($currentURL, $base) !== false) {
				$currentURL = str_replace($base, '', $currentURL);
			}
		}
		
		// Check if the url has a leading trailing slash
		if (substr($currentURL, 0, 1) == '/') {
			$currentURL = ltrim($currentURL, '/');
		}
		
		// Remove the suffix
		if (JFactory::getConfig()->get('sef_suffix') && substr($currentURL, -5) == '.html') {
			$currentURL = str_replace('.html', '', $currentURL);
		}
		
		return $currentURL;
	}
	
	protected function joomlaBuild($uri) {
		$config	= JFactory::getConfig();
		
		if ($this->isJ4()) {
			$url = $uri->toString();

			if ($config->get('sef_rewrite')) {
				$url = $url == 'index.php' ? '' : str_replace('index.php/', '', $url);
			}
			
			if ($config->get('sef_suffix') && $url) {
				if (strpos($url, '?') !== false) {
					list($p1, $p2) = explode('?',$url);
					$url = $p1.'.html?'.$p2;
				} else {
					$url .= '.html';
				}
			}
			
			return $url;
		}
		
		// Get the route
		$route = $uri->getPath();

		// Get the query data
		$query = $uri->getQuery(true);

		if (!isset($query['option'])) {
			return;
		}

		$app  	= JApplication::getInstance('site');
		$menu 	= $app->getMenu();
		
		// Build the component route
		$component = preg_replace('/[^A-Z0-9_\.-]/i', '', $query['option']);
		$tmp       = '';
		$itemID    = !empty($query['Itemid']) ? $query['Itemid'] : null;

		// Use the component routing handler if it exists
		$path = JPATH_SITE . '/components/' . $component . '/router.php';

		// Use the custom routing handler if it exists
		if (file_exists($path) && !empty($query)) {
			$crouter   = $this->getComponentRouter($component);
			$parts     = $crouter->build($query);

			// Encode the route segments
			if ($component != 'com_search') {
				// Cheep fix on searches
				$parts = $this->encodeSegments($parts);
			} else {
				// Fix up search for URL
				$total = count($parts);

				for ($i = 0; $i < $total; $i++) {
					// Urlencode twice because it is decoded once after redirect
					$parts[$i] = urlencode(urlencode(stripcslashes($parts[$i])));
				}
			}

			$result = implode('/', $parts);
			$tmp    = ($result != "") ? $result : '';
		}

		// Build the application route
		$built = false;

		if (!empty($query['Itemid'])) {
			$item = $menu->getItem($query['Itemid']);

			if (is_object($item) && $query['option'] == $item->component) {
				if (!$item->home || $item->language != '*') {
					$tmp = !empty($tmp) ? $item->route . '/' . $tmp : $item->route;
				}

				$built = true;
			}
		}

		if (empty($query['Itemid']) && !empty($itemID)) {
			$query['Itemid'] = $itemID;
		}

		if (!$built) {
			$tmp = 'component/' . substr($query['option'], 4) . '/' . $tmp;
		}

		if ($tmp) {
			$route .= '/' . $tmp;
		} elseif ($route == 'index.php') {
			$route = '';
		}

		// Unset unneeded query information
		if (isset($item) && $query['option'] == $item->component) {
			unset($query['Itemid']);
		}

		unset($query['option']);

		// Set query again in the URI
		$uri->setQuery($query);
		$uri->setPath($route);
		
		if ($config->get('sef_suffix') && !(substr($route, -9) == 'index.php' || substr($route, -1) == '/')) {
			if ($format = $uri->getVar('format', 'html')) {
				$route .= '.' . $format;
				$uri->delVar('format');
			}
		}

		if ($config->get('sef_rewrite')) {
			// Transform the route
			if ($route == 'index.php') {
				$route = '';
			} else {
				$route = str_replace('index.php/', '', $route);
			}
		}
		
		// Add basepath to the uri
		$uri->setPath($route);
		
		// Remove the lang variable
		if ($app->getLanguageFilter()) {
			$uri->delVar('lang');
		}
		
		return $uri->toString();
	}
	
	protected function encodeSegments($segments) {
		foreach ($segments as $key => $value) {
			$segments[$key] = str_replace(':', '-', $value);
		}

		return $segments;
	}
	
	protected static function isJ4() {
		return version_compare(JVERSION, '4.0', '>=');
	}
}