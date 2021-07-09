<?php
/*------------------------------------------------------------------------
# HexData K2 Plugin
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
class  plgHexdataK2 extends plgHexdata
{
	
	function onEditProfile()
	{
		
		$db = JFactory::getDbo();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_K2', JPATH_SITE.'/plugins/hexdata/K2');
		
		$profile = $this->getProfile();
						
		require(dirname(__FILE__).'/tmpl/edit_profile.php');
		
		jexit();
		
	}
	
	function load_fields()
	{
		
		$db = JFactory::getDbo();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_K2', JPATH_SITE.'/plugins/hexdata/K2');
		
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
		
		$query = 'select id, name from #__k2_categories order by name asc';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		
		return $items;
		
	}
	
	function onImportProfile()
	{
		
		$db = JFactory::getDbo();
		
		$dbprefix = $db->getPrefix();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_K2', JPATH_SITE.'/plugins/hexdata/K2');
		
		$profile = $this->getProfile();
		
		$this->csvfields = $this->getCsv_fields();
			
		require(dirname(__FILE__).'/tmpl/import_profile.php');
		
		jexit();
		
	}
	
	function csvoptions($value)	{
	
		$csvoptions = '<option value="">'.JText::_('SELECT_FIELD').'</option>';
	
		foreach($this->csvfields as $key=>$field) :
			
			$csvoptions .= '<option value="'.$key.'"';
			if(strtolower(trim($field))==strtolower(trim($value)))
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
		$lang->load('plg_hexdata_K2', JPATH_SITE.'/plugins/hexdata/K2');
		
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
		
		$fp = fopen($file, "r");
		
                JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/tables');
                
                $k2params = JComponentHelper::getParams('com_k2');
                
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
			
            $row = JTable::getInstance('K2Item', 'Table');
			
                        
			//ID field
			$insert['id'] = $id;
                        
                        $isNew = $id>0?true:false;
                        
                        $row->load($id);
			
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
				
				if(@$params->catid->format == "id")
					$insert['catid'] = @$data[$fields['catid']];
				else	{
					
					$query = 'select id from '.$db->quoteName('#__k2_categories').' where '.$db->quoteName('name').' = '.$db->quote($data[$fields['catid']]);
					$db->setQuery( $query );
					$catid = $db->loadResult();
					
					$table = JTable::getInstance('K2Category', 'Table');
					$table->load($catid);
					
					$isNew = $catid>0?true:false;
					
                                        $alias = JFilterOutput::stringURLSafe($fields['catid']);
                                        
                                        $db->setQuery( 'select id from #__k2_extra_fields_groups order by id asc limit 1' );
                                        $fieldgroup = $db->loadResult();
                                        
					$array = array('id'=>$catid, 'name'=>$data[$fields['catid']], 'alias'=>$alias, 'parent'=>0, 'language'=>'*', 'published'=>1, 'access'=>1, 'extraFieldsGroup'=>$fieldgroup, 'params'=>'{"theme":""}');
					
					// Bind the data.
					if (!$table->bind($array))
					{
						throw new Exception($table->getError());
						return false;
					}
                                        
                                        //Trigger the finder before save event
                                        $dispatcher = JDispatcher::getInstance();
                                        JPluginHelper::importPlugin('finder');
                                        $results = $dispatcher->trigger('onFinderBeforeSave', array('com_k2.category', $table, $isNew));
					
                                        if (!$table->id)
                                        {
                                            $table->ordering = $table->getNextOrder('parent = '.$table->parent.' AND trash=0');
                                        }
                                        
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
			
					//Trigger the finder after save event
                                        $dispatcher = JDispatcher::getInstance();
                                        JPluginHelper::importPlugin('finder');
                                        $results = $dispatcher->trigger('onFinderAfterSave', array('com_k2.category', $table, $isNew));
					
					$insert['catid'] = $table->id;
					
				}
				
			}
						
			//state field
			if($params->published->data == "ask")
				$insert['published'] = $fields['published'];
			elseif($fields['published'] <> "")
				$insert['published'] = @$data[$fields['published']];
				
			//access field
			if($params->access->data == "ask")
				$insert['access'] = $fields['access'];
			elseif($fields['access'] <> "")
				$insert['access'] = @$data[$fields['access']];
								
			//ordering field
			if($params->ordering->data <> "skip")
				$insert['ordering'] = @$data[$fields['access']];
                        else
                            $row->ordering = $row->getNextOrder("catid = {$row->catid} AND trash = 0");
				
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
			elseif($fields['created'] <> "")    {
                            $data[$fields['created']] = JFactory::getDate(@$data[$fields['created']])->toSql();
                            $insert['created'] = @$data[$fields['created']];
                        }
                        
			//created_by field
			if($params->created_by->data == "ask")
				$insert['created_by'] = empty($fields['created_by'])?$user->id:$fields['created_by'];
			elseif($fields['created_by'] <> "")	{
				
				if(@$params->created_by->format == "id")
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
				
			//gallery field
			if($params->gallery->data <> "skip")
				$insert['gallery'] = @$data[$fields['gallery']];
				
			//image_caption field
			if($params->image_caption->data <> "skip")
				$insert['image_caption'] = @$data[$fields['image_caption']];
				
			//image_credits field
			if($params->image_credits->data <> "skip")
				$insert['image_credits'] = @$data[$fields['image_credits']];
				
			//video field
			if($params->video->data <> "skip")
				$insert['video'] = @$data[$fields['video']];
                        
                        //video_caption field
			if($params->video_caption->data <> "skip")
				$insert['video_caption'] = @$data[$fields['video_caption']];
				
			//video_credits field
			if($params->video_credits->data <> "skip")
				$insert['video_credits'] = @$data[$fields['video_credits']];
				
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
                        
                        //params field
			if($params->params->data <> "skip")
				$insert['params'] = @$data[$fields['params']];
                        
                        //plugins field
			if($params->plugins->data <> "skip")
				$insert['plugins'] = @$data[$fields['plugins']];
                        
                        //hits field
			if($params->extra_fields->data <> "skip")
				$insert['extra_fields'] = @$data[$fields['extra_fields']];
			
			// Bind the data.
			if (!$row->bind($insert))
			{
				throw new Exception($table->getError());
				return false;
			}
			
			// Check the data.
			if (!$row->check())
			{
				throw new Exception($table->getError());
				return false;
			}

			$dispatcher = JDispatcher::getInstance();
                        JPluginHelper::importPlugin('k2');
                        $result = $dispatcher->trigger('onBeforeK2Save', array(
                                &$row,
                                $isNew
                        ));
                        if (in_array(false, $result, true))
                        {
                                throw new Exception($row->getError());
                                return false;
                        }

                        //Trigger the finder before save event
                        $dispatcher = JDispatcher::getInstance();
                        JPluginHelper::importPlugin('finder');
                        $results = $dispatcher->trigger('onFinderBeforeSave', array(
                                'com_k2.item',
                                $row,
                                $isNew
                        ));

			// Store the data.
			if (!$row->store())
			{
				throw new Exception($table->getError());
				return false;
			}
			$count++;
			// Trigger the onContentAfterSave event.
	
		}
	
		fclose($fp);
	
		//unlink($file);
		
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
		
		return $id;
	
	}
	
	//export data based on the selected profile
	function startExport()
	{
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_K2', JPATH_SITE.'/plugins/hexdata/K2');
		
		$db = JFactory::getDbo();
		
		$profile = $this->getProfile();
		
		//build query to export the required fields
		try{
			
			$fields = $profile->params->fields;
			
			$columnhead = array();
			
			$query = $db->getQuery(true);
			
			$query->from('#__k2_items AS i');
							
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
				
			if($fields->published->data <> "skip")	{
				$query->select('i.published');
				array_push($columnhead, JText::_('STATUS'));
			}
				
			if($profile->params->type == "export")	{
				
				if($fields->catid->data == "title")	{
					$query->join('LEFT', '#__k2_categories AS c on i.catid = c.id');
					$query->select('c.name');
				}
				else
					$query->select('i.catid');
			}
			else	{
				
				if($fields->catid->data <> "ask" and $fields->catid->format == "title")	{
					$query->join('LEFT', '#__k2_categories AS c on i.catid = c.id');
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
						$query->select('um.'.$fields->modified_by->data);
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
			
			if($fields->gallery->data <> "skip")	{
				$query->select('i.gallery');
				array_push($columnhead, JText::_('GALLERY'));
			}
                        
                        if($fields->image_caption->data <> "skip")	{
				$query->select('i.image_caption');
				array_push($columnhead, JText::_('IMAGE_CAPTION'));
			}
                        
                        if($fields->image_credits->data <> "skip")	{
				$query->select('i.image_credits');
				array_push($columnhead, JText::_('IMAGE_CREDIT'));
			}
                        
                        if($fields->video->data <> "skip")	{
				$query->select('i.video');
				array_push($columnhead, JText::_('VIDEO'));
			}
                        
                        if($fields->video_caption->data <> "skip")	{
				$query->select('i.video_caption');
				array_push($columnhead, JText::_('VIDEO_CAPTION'));
			}
                        
                        if($fields->video_credits->data <> "skip")	{
				$query->select('i.video_credits');
				array_push($columnhead, JText::_('VIDEO_CREDITS'));
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
			
			if($fields->params->data <> "skip")	{
				$query->select('i.params');
				array_push($columnhead, JText::_('PARAMS'));
			}
                        
                        if($fields->extra_fields->data <> "skip")	{
				$query->select('i.extra_fields');
				array_push($columnhead, JText::_('EXTRA_FIELDS'));
			}
                        
                        if($fields->plugins->data <> "skip")	{
				$query->select('i.plugins');
				array_push($columnhead, JText::_('PLUGINS'));
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