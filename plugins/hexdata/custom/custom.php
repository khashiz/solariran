<?php
/*------------------------------------------------------------------------
# HexData Custom Plugin
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
class  plgHexdataCustom extends plgHexdata
{
	
	//fetches the tables in database
	protected function getTables()
	{
		
		$db = JFactory::getDbo();
		
		$query = 'show tables';
		$db->setQuery( $query );
		$items = $db->loadColumn();
		
		return $items;
		
	}
	
	function onEditProfile()
	{
		
		$db = JFactory::getDbo();
		
		$dbprefix = $db->getPrefix();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_custom', JPATH_SITE.'/plugins/hexdata/custom');
		
		$item = $this->getProfile();
		
		$tables = $this->getTables();
		
		require(dirname(__FILE__).'/tmpl/edit_profile.php');
		
		jexit();
		
	}
	
	//get fields of a particular table
	function load_columns()
	{
		
		JRequest::checkToken() or jexit( '{"result":"error", "error":"'.JText::_('INVALID_TOKEN').'"}' );
		
		$obj = new stdClass();
		
		$db = JFactory::getDbo();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_custom', JPATH_SITE.'/plugins/hexdata/custom');
		
		$table = JRequest::getVar('table', '');
		$id = JRequest::getInt('profileid', 0);
		
		$query = 'show fields FROM '.$table;
		$db->setQuery( $query );
		
		if($db->getErrorNum())	{
			throw new Exception($db->getErrorMsg());
			return false;
		}
		
		$columns = $db->loadObjectList();
		
		$obj->html = '';
		
		for($i=0;$i<count($columns);$i++)	{
			
			$query = 'select '.$db->quoteName('column').', '.$db->quoteName('params').' from #__hd_profile_field where '.$db->quoteName('profileid').' = '.$id.' and '.$db->quoteName('column').' = '.$db->quote($columns[$i]->Field);
			$db->setQuery( $query );
			$item = $db->loadObject();
			echo $db->getErrorMsg();
			if(empty($item))	{
				$item = new stdClass();
				$item->column = $columns[$i]->Field;
				$item->params = new stdClass();
				$item->params->type = "skip";
			}
			else
				$item->params = (object)json_decode($item->params);
			
			
			$obj->html .= '<tr data-column="'.$item->column.'">
				<td width="200"><label class="hasTip">'.$item->column.'</label></td>
				<td><select name="fields['.$item->column.'][type]" id="fieldtypes'.$i.'" class="field_type">
					<option value="skip"';
					if(@$item->params->type=="skip")
						$obj->html .= ' selected="selected"';
					$obj->html .= '>'.JText::_('SKIP').'</option>
					<option value="file"';
					if(@$item->params->type=="file")
						$obj->html .= ' selected="selected"';
					$obj->html .= '>'.JText::_('DATA_FILE').'</option>';
			
			if($columns[$i]->Key<>"PRI")	{
			
				$obj->html .= '<option value="defined"';
					if(@$item->params->type=="defined")
						$obj->html .= ' selected="selected"';
					$obj->html .= '>'.JText::_('AS_DEFINED').'</option>
					<option value="reference"';
					if(@$item->params->type=="reference")
						$obj->html .= ' selected="selected"';
					$obj->html .= '>'.JText::_('REFERENCED_TO').'</option>';
					
			}
			
			
			$obj->html .=	'</select>';
				
						
			$obj->html .= $this->loadFieldOptions($item);
			
			$obj->html .= '</td></tr>';
		
		}
		
		$obj->html .= '';
		
		$obj->result = 'success';
		
		jexit(json_encode($obj));
		
	}
	
	protected function loadFieldOptions($item)
	{
		
		$db = JFactory::getDbo();
		
		$tables = $this->getTables();
		
		$dbprefix = $db->getPrefix();
		
		$item->params->type=isset($item->params->type)?$item->params->type:'skip';
		
		$html = '<div class="field_options">';
		
		switch($item->params->type)	{
				
			case 'file':
					
				$item->params->format=isset($item->params->format)?$item->params->format:'';
				
				$html .= ' <span class="format_block"><select name="fields['.$item->column.'][format]">
								<option value="string">'.JText::_('STRING').'</option>';
								
				$html .= '<option value="date"';
								
				if($item->params->format=='date')
					$html .= ' selected="selected"';
						
				$html .= '>'.JText::_('DATE').'</option>';
				
				$html .= '<option value="number"';
				
				if($item->params->format=='number')
					$html .= ' selected="selected"';
				
				$html .= '>'.JText::_('NUMBER').'</option>';
				
				$html .= '<option value="urlsafe"';
				
				if($item->params->format=='urlsafe')
					$html .= ' selected="selected"';
				
				$html .= '>'.JText::_('URLSAFE').'</option>
				   </select></span>';
				
			break;
			
			case 'defined':
			
				$item->params->default=isset($item->params->default)?$item->params->default:'';
			
				$html .= ' <span class="default_block"><input name="fields['.$item->column.'][default]" id="fields['.$item->column.'][default]" value=\''.$item->params->default.'\' /></span>';
			break;
			
			case 'reference':
				
				$html .= ' <span class="table_block"><select class="field_table" name="fields['.$item->column.'][table]"><option value="">'.JText::_('SELECT_TABLE').'</option>';
					
					$item->params->table=isset($item->params->table)?$item->params->table:null;
					$item->params->reftext=isset($item->params->reftext)?$item->params->reftext:null;
					
					foreach($tables as $table)	{
						$table = str_replace($dbprefix, '#__', $table);
						$html .= '<option value="'.$table.'"';
						if($item->params->table==$table)
							$html .= ' selected="selected"';
						$html .= '>'.$table.'</option>';
					}
					
				$html .= '</select></span>';
				
				$query = 'show fields FROM '.$db->quoteName($item->params->table);
				$db->setQuery( $query );
				
				$cols = (array)$db->loadObjectList();
				
				if($db->getErrorNum())	{
					throw new Exception($db->getErrorMsg());
					return false;
				}
				
				$html .= ' <span class="column_block">';
				
				$html .= ' <span class="label">'.JText::_('REFERENCED_COLUMN').'</span> <select name="fields['.$item->column.'][reftext]">';
				
				for($j=0;$j<count($cols);$j++)	{
					$html .= '<option value="'.$cols[$j]->Field.'"';
					if(isset($item->params->reftext) and $cols[$j]->Field==$item->params->reftext)	{
						$html .= ' selected="selected"';
					}
					$html .= '>'.$cols[$j]->Field.'</option>';
				}
				
				$html .= '</select></span>';
			
			break;
			
		}
		
		$html .= '</div>';
					
		return $html;
		
	}
	
	//get referenced columns
	protected function getReferColumns()
	{
		
		$obj = new stdClass();
		$obj->result = 'error';
		
		$db = JFactory::getDbo();
		
		$table = JRequest::getVar('table', '');
		$column = JRequest::getVar('column', '');
		$id = JRequest::getInt('profileid', 0);
		
		if(empty($column))	{
			$obj->error = JText::_('PLZ_SEL_COLUMN_FIRST');
			return $obj;
		}
		
		$query = 'select '.$db->quoteName('params').' from #__hd_profile_field where '.$db->quoteName('profileid').' = '.$id.' and '.$db->quoteName('column').' = '.$db->quote($column);
		$db->setQuery( $query );
		$item = $db->loadObject();
		
		if(empty($item))	{
			$params = new stdClass();
		}
		else
			$params = (object)json_decode($item->params);
		
		$query = 'show fields FROM '.$table;
		$db->setQuery( $query );
		
		if($db->getErrorNum())	{
			$obj->error = $db->getErrorMsg();
			return $obj;
		}
		
		$cols = $db->loadObjectList();
		
		$obj->html = '<select name="fields['.$column.'][reftext]">';
				
		for($i=0;$i<count($cols);$i++)	{
			$obj->html .= '<option value="'.$cols[$i]->Field.'"';
			if(isset($params->reftext) and $cols[$i]->Field==$params->reftext)	{
				$obj->html .= ' selected="selected"';
			}
			$obj->html .= '>'.$cols[$i]->Field.'</option>';
		}
		
		$obj->html .= '</select>';
		
		$obj->result = 'success';
		
		return $obj;
		
	}
	
	function load_refer_columns()
	{
		
		$obj = $this->getReferColumns();
		
		jexit(json_encode($obj));
		
	}
	
	function onSaveProfile($id)
	{
		
		settype($id, 'int');
		
		$db = JFactory::getDbo();
		
		$fields = JRequest::getVar('fields', array(), 'post', 'array');
		
		$nodelete = array();
		
		foreach($fields as $column=>$field)	{
			
			if($field['type'] <> "skip")	{
								
				array_push($nodelete, $column);
				
				$query = 'select count( * ) from #__hd_profile_field where '.$db->quoteName('profileid').' = '.$db->quote($id).' and '.$db->quoteName('column').' = '.$db->quote($column);
				$db->setQuery( $query );
				$count = $db->loadResult();
				
				if($count)	{
					$query = 'update #__hd_profile_field set params = '.$db->quote(json_encode($field)).' where '.$db->quoteName('profileid').' = '.$id.' and '.$db->quoteName('column').' = '.$db->quote($column);				
				}
				else	{
					$query = 'insert into #__hd_profile_field ('.$db->quoteName('profileid').', '.$db->quoteName('column').', '.$db->quoteName('params').') values ('.$id.', '.$db->quote($column).', '.$db->quote(json_encode($field)).')';
				}
				
				$db->setQuery( $query );
				if(!$db->execute())	{
					throw new Exception($db->getErrorMsg());
					return false;
				}
				
			}			
			
		}
		
		$query = 'delete from #__hd_profile_field where '.$db->quoteName('profileid').' = '.$db->quote($id).' and '.$db->quoteName('column').' not in ("'.implode('", "', $nodelete).'")';
		$db->setQuery( $query );
		if(!$db->execute())	{
			throw new Exception($db->getErrorMsg());
			return false;
		}
		
		return true;
		
	}
	
	function onDeleteProfile($oid)
	{
		
		$db = JFactory::getDbo();
		
		$query = 'delete from #__hd_profile_field where profileid = '.$oid;
		$db->setQuery( $query );
		
		if(!$db->execute())	{
			throw new Exception($db->getErrorMsg());
			return false;
		}
		
		return true;
		
	}
	
	function onImportProfile()
	{
		
		$db = JFactory::getDbo();
		
		$dbprefix = $db->getPrefix();
		
		$lang = JFactory::getLanguage();
		$lang->load('plg_hexdata_custom', JPATH_SITE.'/plugins/hexdata/custom');
		
		$profile = $this->getProfile();
		
		$fields = $this->getProfile_fields();
			
		$csvfields = $this->getCsv_fields();
			
		require(dirname(__FILE__).'/tmpl/import_profile.php');
		
		jexit();
		
	}
	
	function getProfile_fields()	{
		
		$db = JFactory::getDbo();
		
		$id = JRequest::getInt('profileid', 0);
		
		$query = 'select * from #__hd_profile_field where profileid = '.$id.' order by id asc';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		
		return $items;
		
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
		
		$csvfields = JRequest::getVar('csvfield', array(), 'post', 'array');
		$profilefields = JRequest::getVar('profilefield', array(), 'post', 'array');
		
		if(count($csvfields) == 0 or count($profilefields) == 0)	{
			throw new Exception(JText::_('PLZ_UPLOAD_VALID_CSV_FILE'));
			return false;
		}
		
		/*//Check if the fields are selected
		$fields=array();
		
		foreach($csvfields as $k=>$v)	{
			if($v != "")	{
				$fields[$k] = $v;
			}
		}
		
		if(count($fields)<1)	{
			throw new Exception(JText::_('PLZ_SELECT_ATLEAST_FIELD'));
			return false;
		}*/
		
		$profile = $this->getProfile();
		
		$query = 'SHOW KEYS FROM '.$db->quoteName($profile->params->table).' WHERE Key_name = "PRIMARY"';
		$db->setQuery( $query );
		$key = $db->loadObject();
		
		$primary = $key->Column_name;
		
		$fp = fopen($file, "r");
		
		$header = fgetcsv($fp, 100000, ",", '"');
		$n = 0;
		while(($data = fgetcsv($fp, 100000, ",", '"')) !== FALSE)	{
			
			$isNew = true;
			$insert = new stdClass();
			$insert->$primary = null;
			
			foreach($csvfields as $key=>$field)	{
				
				if($field !== "") :
				
					$query = 'select * from #__hd_profile_field where id = '. (int)$profilefields[$key];
					$db->setQuery( $query );
					$item = $db->loadObject();
					
					if(empty($item))	{
						throw new Exception(JText::_('INTERNAL_SERVER_ERROR'));
						return false;
					}
					
					$params = json_decode($item->params);
					
					$params->type = isset($params->type)?$params->type:"skip";
					
					if(!empty($primary) and $item->column==$primary and $params->type <> "skip")	{
						
						$query = 'select count(*) from '.$db->quoteName($profile->params->table).' where '.$db->quoteName($primary).' = '.$db->quote($data[$field]);
						$db->setQuery( $query );
						$count = $db->loadResult();
						
						$isNew = $count>0?false:true;
						
					}
					
					$column = $item->column;
					
					switch($params->type) :
					
						case 'file':
						
							if($params->format == "urlsafe")
								$data[$field] = JFilterOutput::stringURLSafe($data[$field]);
							elseif($params->format == "number")
								$data[$field] = (int)$data[$field];
							elseif($params->format == "date")	{
								$date = JFactory::getDate($data[$field]);
								$data[$field] = $date->toSql();
							}
						
							$insert->$column = $data[$field];
						
						break;
						
						case 'defined':
						
							$insert->$column = $params->default;
						
						break;
						
						case 'reference':
						
							try{
								$insert->$column = $this->getValue($params, $data[$field]);
							}catch(Exception $e){
								throw new Exception($e->getMessage());
								return false;
							}
						
						break;
					
					endswitch;
				
				endif;
								
			}
			
			if($isNew)	{
			
				if(!$db->insertObject($profile->params->table, $insert, $primary))	{
					throw new Exception($db->stderr());
					return false;
				}
			
			}
			else	{
				
				if(!$db->updateObject($profile->params->table, $insert, $primary))	{
					throw new Exception($db->stderr());
					return false;
				}
				
			}
			
			$n++;
	
		}
	
		fclose($fp);
	
		unlink($file);
		
		return $n;
		
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
		
		$db = JFactory::getDbo();
		
		$profile = $this->getProfile();
		
		$query = 'SHOW KEYS FROM '.$db->quoteName($profile->params->table).' WHERE Key_name = "PRIMARY"';
		$db->setQuery( $query );
		$key = $db->loadObject();
		
		$primary = isset($key->Column_name)?$key->Column_name:null;
		
		//get the column titles for heading row
		$query = 'select '.$db->quoteName('column').' from #__hd_profile_field where profileid = '.(int)$profile->id.' order by id asc';
		$db->setQuery( $query );
		$columnhead = $db->loadColumn();
		
		//get all the fields to export for the particular profile
		$query = 'select '.$db->quoteName('column').', '.$db->quoteName('params').' from #__hd_profile_field where '.$db->quoteName('profileid').' = '.(int)$profile->id.' order by id asc';
		$db->setQuery( $query );
		$fields = (array)$db->loadObjectList();
		
		//build query to export the required fields
		try{
		
			$query = $db->getQuery(true);
			
			$query->from($profile->params->table.' AS i');
			
			for($i=0;$i<count($fields);$i++)	{
				
				$field = $fields[$i];
				
				$params = json_decode($field->params);
				
				$params->type = isset($params->type)?$params->type:"skip";
				
				switch($params->type)
				{
					
					case 'reference':
						
						$q = 'SHOW KEYS FROM '.$db->quoteName($params->table).' WHERE Key_name = "PRIMARY"';
						$db->setQuery( $q );
						$key = $db->loadObject();
					
						$alias = 'a'.$i;
						$query->join('LEFT', $db->quoteName($params->table).' AS '.$alias.' on '.$db->quoteName('i.'.$field->column).' = '.$db->quoteName($alias.'.'.$key->Column_name));
						$query->select($db->quoteName($alias.'.'.$params->reftext));
					
					break;
					
					default:
						$query->select($db->quoteName('i.'.$field->column));
					break;
					
									
				}
				
			}
			
			if(!empty($primary))	{
				$query->group($db->quoteName('i.'.$primary));
			
				$query->order($db->quoteName('i.'.$primary).' asc');
			}
			$query = $query->__toString();
			
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
			$f=array();
			foreach($fields as $v)
				array_push($f, mb_convert_encoding($v, 'UTF-16LE', 'utf-8'));
			fputcsv($output, $f, ',', '"');
		}
		
		fclose($output);
		
		return true;
		
	}
	
}