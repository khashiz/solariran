<?php
/*------------------------------------------------------------------------
# HexData Joomla Article Plugin
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2014 www.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');

require(JPATH_ADMINISTRATOR.'/components/com_hexdata/classes/plghexdata.php');

/**
 * Joomla! HexData Plugin
 *
 * @package		Joomla
 * @subpackage	Plugin
 */
class  plgHexdataArticle extends plgHexdata
{
	
	function onEditProfile()
	{
		
		$db = JFactory::getDbo();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_article', JPATH_SITE.'/plugins/hexdata/article');
		
		$profile = $this->getProfile();
						
		require(dirname(__FILE__).'/tmpl/edit_profile.php');
		
		jexit();
		
	}
	
	function load_fields()
	{
		
		$db = JFactory::getDbo();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_article', JPATH_SITE.'/plugins/hexdata/article');
		
		$type = JRequest::getCmd('type', 'import');
		
		$profile = $this->getProfile();
		
		if($type == "export")
			$cats = $this->getCats();
						
		require(dirname(__FILE__).'/tmpl/'.$type.'fields.php');
		
		jexit();
		
	}
	
	function getCats()
	{
		
		$db = JFactory::getDbo();
		
		$query = 'select id, title from #__categories where published <> -2 and level <> 0 and extension = "com_content" order by title asc';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		
		return $items;
		
	}
	
	function onImportProfile()
	{
		
		$db = JFactory::getDbo();
		
		$dbprefix = $db->getPrefix();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_article', JPATH_SITE.'/plugins/hexdata/article');
		
		$profile = $this->getProfile();
		
		$this->csvfields = $this->getCsv_fields();
			
		require(dirname(__FILE__).'/tmpl/import_profile.php');
		
		jexit();
		
	}
	
	function csvoptions($value)	{
	
		$csvoptions = '<option value="">'.JText::_('SELECT_FIELD').'</option>';
	
		foreach($this->csvfields as $key=>$field) :
			
			$csvoptions .= '<option value="'.$key.'"';
			if($field==$value)
				$csvoptions .= ' selected="selected"';
			$csvoptions .= '>'.$field.'</option>';
								
		endforeach;
		
		return $csvoptions;
		
	}
	
	function getCsv_fields()
	{
		
		$db = JFactory::getDbo();
		
		$file = JPATH_ADMINISTRATOR.'/components/com_hexdata/uploads/data.csv';
		
		if(!is_file($file))	{
			throw new Exception(JText::_('PLZ_SELECT_FILE'));
			return false;
		}
	
		if(filesize($file) == 0)	{
			throw new Exception(JText::_('PLZ_UPLOAD_VALID_CSV_FILE'));
			return false;
		}
		
		$fp = fopen($file, "r");
		
		$data = fgetcsv($fp, 100000, ",");
		
		return $data;		
		
	}
	
	function startImport()
	{
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_article', JPATH_SITE.'/plugins/hexdata/article');
		
		$dispatcher = JDispatcher::getInstance();
		
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$date = JFactory::getDate();
		
		$file = JPATH_ADMINISTRATOR.'/components/com_hexdata/uploads/data.csv';
		
		if(!is_file($file))	{
			throw new Exception(JText::_('PLZ_SELECT_FILE'));
			return false;
		}
	
		if(filesize($file) == 0)	{
			throw new Exception(JText::_('PLZ_UPLOAD_VALID_CSV_FILE'));
			return false;
		}
		
		$fields = JRequest::getVar('fields', array());
		
		if(count($fields) == 0)	{
			throw new Exception(JText::_('PLZ_UPLOAD_VALID_CSV_FILE'));
			return false;
		}
		
		$profile = $this->getProfile();
		$params = $profile->params->fields;
		
		//check the primary key if not to skip and column isn't selected
		if($params->id->data <> "skip" and empty($fields['id']) and $fields['id'] <> 0)	{
			throw new Exception(JText::_('PLZ_SELECT_ID'));
			return false;
		}
		else
			$id = null;
		
		//check title if the column isn't selected
		if($fields['title'] == "")	{
			throw new Exception(JText::_('PLZ_SELECT_TITLE'));
			return false;
		}
		
		//check catid if need to ask and category not selected
		if($params->catid->data == "ask" and empty($fields['catid']))	{
			throw new Exception(JText::_('PLZ_SELECT_CAT'));
			return false;
		}
		elseif($params->catid->data <> "ask" and $fields['catid'] == "")	{ //check if not to ask and csv column isn't selected
			continue;
		}
		
		$fp = fopen($file, "r");
		
		$header = fgetcsv($fp, 100000, ",", '"');
		$count=0;
		while(($data = fgetcsv($fp, 100000, ",", '"')) !== FALSE)	{
			
			$insert = array();
			
			//check if not to skip id and column is blank
			if($params->id->data <> "skip")	{
				
				if(empty($data[$fields['id']]))
					continue;
				else
					$id = $data[$fields['id']];
			}
			
			//check title if the column is blank
			if(empty($data[$fields['title']]))	{
				continue;
			}
			
			if($params->catid->data <> "ask" and empty($data[$fields['catid']]))	{
				continue;
			}
			
			//ID field
			$insert['id'] = $id;
			
			//title field
			$insert['title'] = $data[$fields['title']];
			
			//alias field
			$insert['alias'] = $data[$fields['title']];
			if($params->alias->data == "file" and $fields['alias'] <> "" and !empty($data[$fields['alias']]))
				$insert['alias'] = $data[$fields['alias']];
				
			//catid field
			if($params->catid->data == "ask")
				$insert['catid'] = $fields['catid'];
			else	{
				
				if($params->catid->format == "id")
					$insert['catid'] = @$data[$fields['catid']];
				else	{
					
					$query = 'select id from '.$db->quoteName('#__categories').' where '.$db->quoteName('title').' = '.$db->quote($data[$fields['catid']]);
					$db->setQuery( $query );
					$catid = $db->loadResult();
					
					$table = JTable::getInstance('category');
					$table->load($catid);
					
					$isNew = $catid>0?true:false;
					
					$array = array('id'=>$catid, 'title'=>$data[$fields['catid']], 'parent_id'=>1, 'extension'=>'com_content', 'language'=>'*', 'published'=>1, 'level'=>1);
					
					// Bind the data.
					if (!$table->bind($array))
					{
						throw new Exception($table->getError());
						return false;
					}
					
					$rules = new JAccessRules('{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
					$table->setRules($rules);
					
					// Check the data.
					if (!$table->check())
					{
						throw new Exception($table->getError());
						return false;
					}
			
					// Trigger the onContentBeforeSave event.
					$result = $dispatcher->trigger('onContentBeforeSave', array('com_categories.category', &$table, $isNew));
					if (in_array(false, $result, true))
					{
						throw new Exception($table->getError());
						return false;
					}
			
					// Store the data.
					if (!$table->store())
					{
						throw new Exception($table->getError());
						return false;
					}
			
					// Trigger the onContentAfterSave event.
					$dispatcher->trigger('onContentAfterSave', array('com_categories.category', &$table, $isNew));
			
					// Rebuild the path for the category:
					if (!$table->rebuildPath($table->id))
					{
						throw new Exception($table->getError());
						return false;
					}
			
					// Rebuild the paths of the category's children:
					if (!$table->rebuild($table->id, $table->lft, $table->level, $table->path))
					{
						throw new Exception($table->getError());
						return false;
					}
					
					$insert['catid'] = $table->id;
					
				}
				
			}
						
			//state field
			if($params->state->data == "ask")
				$insert['state'] = $fields['state'];
			elseif($fields['state'] <> "")
				$insert['state'] = @$data[$fields['state']];
				
			//access field
			if($params->access->data == "ask")
				$insert['access'] = $fields['access'];
			elseif($fields['access'] <> "")
				$insert['access'] = @$data[$fields['access']];
								
			//ordering field
			if($params->ordering->data <> "skip")
				$insert['ordering'] = @$data[$fields['access']];
				
			//featured field
			if($params->featured->data == "ask")
				$insert['featured'] = $fields['featured'];
			elseif($fields['featured'] <> "")
				$insert['featured'] = @$data[$fields['featured']];
				
			//language field
			if($params->language->data == "ask")
				$language = $fields['language'];
			elseif($fields['language'] <> "")
				$language = @$data[$fields['language']];
				
			$insert['language'] = empty($language)?'*':$language;
			
			//introtext field
			$insert['introtext'] = @$data[$fields['introtext']];
			
			//fulltext field
			if($params->fulltext->data <> "skip")
				$insert['fulltext'] = @$data[$fields['fulltext']];
			
			//created field
			if($params->created->data == "ask")
				$insert['created'] = $fields['created'];
			elseif($fields['created'] <> "")
				$insert['created'] = @$data[$fields['created']];
							
			//created_by field
			if($params->created_by->data == "ask")
				$insert['created_by'] = empty($fields['created_by'])?$user->id:$fields['created_by'];
			elseif($fields['created_by'] <> "")	{
				
				if($params->created_by->format == "id")
					$insert['created_by'] = @$data[$fields['created_by']];
				else	{
					
					$query = 'select id from #__users where '.$db->quoteName($params->created_by->format).' = '.$db->quote($data[$fields['created_by']]);
					$db->setQuery( $query );
					$insert['created_by'] = $db->loadResult();
					
				}
			}
						
			//created_by_alias field
			if($params->created_by_alias->data == "ask")
				$insert['created_by_alias'] = $fields['created_by_alias'];
			elseif($fields['created_by_alias'] <> "")
				$insert['created_by_alias'] = @$data[$fields['created_by_alias']];
				
			//modified field
			if($params->modified->data == "file" and $fields['modified'] <> "")
				$insert['modified'] = @$data[$fields['modified']];
			elseif($params->modified->data == "current")
				$insert['modified'] = $date->toSql();
				
			
			//modified_by field
			if($params->modified_by->data == "loggedin")
				$insert['modified_by'] = $user->id;
			elseif($params->modified_by->data == "file" and $fields['modified_by'] <> "")	{
				
				if($params->modified_by->format == "id")
					$insert['modified_by'] = @$data[$fields['modified_by']];
				else	{
					
					$query = 'select id from #__users where '.$db->quoteName($params->modified_by->format).' = '.$db->quote($data[$fields['modified_by']]);
					$db->setQuery( $query );
					$insert['modified_by'] = $db->loadResult();
					
				}
			}
			
			//publish_up field
			if($params->publish_up->data == "ask")
				$publish_up = $fields['publish_up'];
			elseif($fields['publish_up'] <> "")
				$publish_up = @$data[$fields['publish_up']];
			else
				$publish_up = $date->toSql();
				
			$insert['publish_up'] = empty($publish_up)?$date->toSql():$publish_up;
				
			//publish_down field
			if($params->publish_down->data == "ask")
				$insert['publish_down'] = $fields['publish_down'];
			elseif($fields['publish_down'] <> "")
				$insert['publish_down'] = @$data[$fields['publish_down']];
				
			//images field
			if($params->images->data <> "skip")
				$insert['images'] = @$data[$fields['images']];
				
			//urls field
			if($params->urls->data <> "skip")
				$insert['urls'] = @$data[$fields['urls']];
				
			//attribs field
			if($params->attribs->data <> "skip")
				$insert['attribs'] = @$data[$fields['attribs']];
				
			//version field
			if($params->version->data <> "skip")
				$insert['version'] = @$data[$fields['version']];
				
			//metadesc field
			if($params->metadesc->data <> "skip")
				$insert['metadesc'] = @$data[$fields['metadesc']];
				
			//metakey field
			if($params->metakey->data <> "skip")
				$insert['metakey'] = @$data[$fields['metakey']];
				
			//metadata field
			if($params->metadata->data <> "skip")
				$insert['metadata'] = @$data[$fields['metadata']];
				
			//hits field
			if($params->hits->data <> "skip")
				$insert['hits'] = @$data[$fields['hits']];
			
			$rules = '';
			
			if($params->asset_id->data == "file")	{
				
				$rules = @$data[$fields['asset_id']];
				
			}
			
			$rules = empty($rules)?'{"core.delete":[],"core.edit":[],"core.edit.state":[]}':$rules;
						
			$table = JTable::getInstance('content');
			$table->load($id);
			
			// Bind the data.
			if (!$table->bind($insert))
			{
				throw new Exception($table->getError());
				return false;
			}
			
			$rules = new JAccessRules('{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}');
			$table->setRules($rules);
			
			// Check the data.
			if (!$table->check())
			{
				throw new Exception($table->getError());
				return false;
			}
	
			// Trigger the onContentBeforeSave event.
			$result = $dispatcher->trigger('onContentBeforeSave', array('com_content.article', &$table, $isNew));
			if (in_array(false, $result, true))
			{
				throw new Exception($table->getError());
				return false;
			}
	
			// Store the data.
			if (!$table->store())
			{
				throw new Exception($table->getError());
				return false;
			}print_r($insert);
			$count++;
			// Trigger the onContentAfterSave event.
			$dispatcher->trigger('onContentAfterSave', array('com_content.article', &$table, $isNew));
	
		}
	
		fclose($fp);
	
		unlink($file);
		
		return $count;
		
	}
	
	//get the id of refereced table column while importing
	function getValue($params, $value)
	{
		
		$db = JFactory::getDbo();
		
		$q = 'SHOW KEYS FROM '.$db->quoteName($params->table).' WHERE Key_name = "PRIMARY"';
		$db->setQuery( $q );
		$key = $db->loadObject();
		
		$query = 'select '.$db->quoteName($key->Column_name).' from '.$db->quoteName($params->table).' where lower('.$db->quoteName($params->reftext).') = '.$db->quote(strtolower($value)).' limit 1';
		$db->setQuery( $query );
		$id = $db->loadResult();
		
		/*if(empty($id))	{
			
			$query = 'insert into '.$db->quoteName($params->table).' ('.$db->quoteName($params->reftext).') values ('.$db->quote($value).')';
			$db->setQuery( $query );
			if(!$db->query())	{
				throw new Exception($db->getErrorMsg());
			}
			
			$id = $db->insertid();

			
		}*/
		
		return $id;
	
	}
	
	//export data based on the selected profile
	function startExport()
	{
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_article', JPATH_SITE.'/plugins/hexdata/article');
		
		$db = JFactory::getDbo();
		
		$profile = $this->getProfile();
		
		//build query to export the required fields
		try{
			
			$fields = $profile->params->fields;
			
			$columnhead = array();
			
			$query = $db->getQuery(true);
			
			$query->from('#__content AS i');
							
			if($fields->id->data <> "skip")	{
				$query->select('i.id');
				array_push($columnhead, JText::_('ID'));
			}
				
			$query->select('i.title');
			array_push($columnhead, JText::_('TITLE'));
				
			if($fields->alias->data <> "skip")	{
				$query->select('i.alias');
				array_push($columnhead, JText::_('ALIAS'));
			}
				
			$query->select('i.introtext');
			array_push($columnhead, JText::_('INTROTEXT'));
				
			if($fields->fulltext->data <> "skip")	{
				$query->select('i.fulltext');
				array_push($columnhead, JText::_('FULLTEXT'));
			}
				
			if($fields->state->data <> "skip")	{
				$query->select('i.state');
				array_push($columnhead, JText::_('STATUS'));
			}
				
			if($profile->params->type == "export")	{
				
				if($fields->catid->data == "title")	{
					$query->join('LEFT', '#__categories AS c on i.catid = c.id');
					$query->select('c.title');
				}
				else
					$query->select('i.catid');
			}
			else	{
				
				if($fields->catid->data <> "ask" and $fields->catid->format == "title")	{
					$query->join('LEFT', '#__categories AS c on i.catid = c.id');
					$query->select('c.title as cat');
				}
				else	{
					$query->select('i.catid');
				}
				
			}
			array_push($columnhead, JText::_('CATEGORY'));
			
			if($fields->created->data <> "skip")	{
				$query->select('i.created');
				array_push($columnhead, JText::_('CREATED'));
			}
			
			if($profile->params->type == "export" and $fields->created_by->data <> "skip")	{
			
				if($fields->created_by->data == "username" or $fields->created_by->data == "email")	{
					$query->join('LEFT', '#__users AS uc on i.created_by = uc.id');
					$query->select('uc.'.$fields->created_by->data);
				}
				else
					$query->select('i.created_by');
					
				array_push($columnhead, JText::_('CREATED_BY'));
			
			}
			elseif($profile->params->type == "import")	{
				
				if($fields->created_by->data == "file" and $fields->created_by->format <> "id")	{
					$query->join('LEFT', '#__users AS uc on i.created_by = uc.id');
					$query->select('uc.'.$fields->created_by->format);
				}
				else
					$query->select('i.created_by');
					
				array_push($columnhead, JText::_('CREATED_BY'));
				
			}
			
			if($fields->created_by_alias->data <> "skip")	{
				$query->select('i.created_by_alias');
				array_push($columnhead, JText::_('CREATED_BY_ALIAS'));
			}
				
			if($fields->modified->data <> "skip")	{
				$query->select('i.modified');
				array_push($columnhead, JText::_('MODIFIED'));
			}
			
			if($fields->modified_by->data <> "skip")	{
			
				if($profile->params->type == "export")	{
					
					if($fields->modified_by->data == "username" or $fields->modified_by->data == "email")	{
						$query->join('LEFT', '#__users AS um on i.modified_by = um.id');
						$query->select('um.'.$fields->created_by->data);
					}
					else
						$query->select('i.modified_by');
											
				}
				else	{
					
					if($fields->modified_by->data == "file" and $fields->modified_by->format <> "id")	{
						$query->join('LEFT', '#__users AS um on i.modified_by = um.id');
						$query->select('um.'.$fields->modified_by->format);
					}
					else
						$query->select('i.modified_by');
					
				}
				
				array_push($columnhead, JText::_('MODIFIED_BY'));
			
			}
			
			if($fields->publish_up->data <> "skip")	{
				$query->select('i.publish_up');
				array_push($columnhead, JText::_('PUBLISH_UP'));
			}
				
			if($fields->publish_down->data <> "skip")	{
				$query->select('i.publish_down');
				array_push($columnhead, JText::_('PUBLISH_DOWN'));
			}
			
			if($fields->images->data <> "skip")	{
				$query->select('i.images');
				array_push($columnhead, JText::_('IMAGES'));
			}
				
			if($fields->urls->data <> "skip")	{
				$query->select('i.urls');
				array_push($columnhead, JText::_('URLS'));
			}
				
			if($fields->attribs->data <> "skip")	{
				$query->select('i.attribs');
				array_push($columnhead, JText::_('ATTRIBS'));
			}
				
			if($fields->version->data <> "skip")	{
				$query->select('i.version');
				array_push($columnhead, JText::_('VERSION'));
			}
				
			if($fields->ordering->data <> "skip")	{
				$query->select('i.ordering');
				array_push($columnhead, JText::_('ORDERING'));
			}
				
			if($fields->metadesc->data <> "skip")	{
				$query->select('i.metadesc');
				array_push($columnhead, JText::_('METADESC'));
			}
				
			if($fields->metakey->data <> "skip")	{
				$query->select('i.metakey');
				array_push($columnhead, JText::_('METAKEY'));
			}
				
			if($fields->access->data <> "skip")	{
				$query->select('i.access');
				array_push($columnhead, JText::_('ACCESS'));
			}
				
			if($fields->hits->data <> "skip")	{
				$query->select('i.hits');
				array_push($columnhead, JText::_('HITS'));
			}
				
			if($fields->metadata->data <> "skip")	{
				$query->select('i.metadata');
				array_push($columnhead, JText::_('METADATA'));
			}
				
			if($fields->featured->data <> "skip")	{
				$query->select('i.featured');
				array_push($columnhead, JText::_('FEATURED'));
			}
				
			if($fields->language->data <> "skip")	{
				$query->select('i.language');
				array_push($columnhead, JText::_('LANGUAGE'));
			}
			
			if($fields->asset_id->data == "asset_id")	{
				$query->select('i.asset_id');
				array_push($columnhead, JText::_('ARTICLE_PERMISSIONS'));
			}
			elseif($fields->asset_id->data == "rules")	{
				$query->join('LEFT', '#__assets AS a on i.asset_id = a.id');
				$query->select('a.rules as rules');
				array_push($columnhead, JText::_('ARTICLE_PERMISSIONS'));
			}
			
			$query->group('i.id');
			
			$orderby = isset($profile->params->orderby)?$profile->params->orderby:'i.ordering asc';
			
			if(isset($profile->params->catid) and $profile->params->catid)
				$query->where('i.catid = '.(int)$profile->params->catid);
			
			$query->order($orderby);
			
			$db->setQuery( $query );
			
			$data = $db->loadRowList();
			
			if($db->getErrorNum())	{
				throw new Exception($db->getErrorMsg());
			}
		
		}catch(Exception $e){
			throw new Exception($e->getMessage());
			return false;
		}
		
		//push the heading row at the top
		
		array_unshift($data, $columnhead);
		
		// output headers so that the file is downloaded rather than displayed
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		foreach ($data as $fields) {
			/*$f=array();
			foreach($fields as $v)
				array_push($f, mb_convert_encoding($v, 'UTF-16LE', 'utf-8'));*/
			fputcsv($output, $fields, ',', '"');
		}
		
		fclose($output);
		
		return true;
		
	}
	
}