<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Helper{
    function is_set($data){
        if(isset($data)){
            return $data;
        }
        else{
            return null;
        }
    }
	public function generate_obs_dropdown($obs,$form_id){
		
		$html = "";
		$program_id = 0;
		$product_id = 0;
		foreach($obs as $obs_record){
			$new_program_id = ($program_id != $obs_record->program_id);
			$new_product_id = ($product_id != $obs_record->product_id);
			if($new_product_id && $product_id != 0){
				$html .= '</ul>' ;
				$html .= '</li>' ;
			}
			if($new_program_id && $program_id != 0){
				$html .= '</ul>' ;
				$html .= '</li>' ;
			}
			if($new_program_id){
				$program_id = $obs_record->program_id;
				$html .= '<li class="dropdown-submenu">';
				$html .= $obs_record->program_name;
				$html .= '<ul class="dropdown-menu">';
			}
			if($new_product_id){
				$product_id = $obs_record->product_id;
				$html .=  '<li class="dropdown-submenu">';
				$html .= $obs_record->product_name;
				$html .=  '<ul class="dropdown-menu">';
			}
			$html .=  '<li class="dropdown-submenu">';
			$html .= '<a class="obs-option" formid="'.$form_id.'" value="'.$obs_record->obs_id.'">';
			$html .= $obs_record->wbs_name;
			$html .= '</a>' ;
			$html .= '</li>' ;
			
			
		}
		$html .= '</ul>' ;
		$html .= '</li>' ;
		$html .= '</ul>' ;
		$html .= '</li>' ;
		return $html;
	}
	
	public function process_obs($obs){
		$program = array();
		$product = array();
		$wbs = array();
		
		$program_id = 0;
		$product_id = 0;
		$wbs_id = 0;
		foreach($obs as $obs_record){
			$new_program_id = ($program_id != $obs_record->program_id);
			$new_product_id = ($product_id != $obs_record->product_id);
			$new_wbs_id = ($wbs_id != $obs_record->wbs_id);
			if($new_program_id){
				$program_id = $obs_record->program_id;
				array_push($program,array('program_id'=>$obs_record->program_id
				,'program_code'=>$obs_record->program_code
				,'program_name'=>$obs_record->program_name));
				$product[$program_id] = array();
				$wbs[$program_id] = array();
			}
			if($new_product_id){
				$product_id = $obs_record->product_id;
				array_push($product[$program_id],array('product_id'=>$obs_record->product_id
				,'product_code'=>$obs_record->product_code
				,'product_name'=>$obs_record->product_name));
				$wbs[$program_id][$product_id] = array();
			}
			if($new_wbs_id){
				$wbs_id = $obs_record->wbs_id;
				array_push($wbs[$program_id][$product_id], array('obs_id'=>$obs_record->obs_id
				,'wbs_id'=>$obs_record->wbs_id
				,'wbs_code'=>$obs_record->wbs_code
				,'wbs_name'=>$obs_record->wbs_name));
			}
			
			
		}
		
		return array('program'=>$program,'product'=>$product,'wbs'=>$wbs);
	}
	/**
	 * Generate CSV from a array
	 *
	 * @param	object	$array		array result object
	 * @param	string	$delim		Delimiter (default: ,)
	 * @param	string	$newline	Newline character (default: \n)
	 * @param	string	$enclosure	Enclosure (default: ")
	 * @return	string
	 */
	public function csv_from_result($array, $delim = ',', $newline = "\n", $enclosure = '"')
	{
		if ( ! is_array($array) || !is_array($array[0] ))
		{
			show_error('You must submit a valid array');
		}

		$out = '';
		// First generate the headings from the table column names
		foreach (array_keys($array[0]) as $name)
		{
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
		}

		$out = substr($out, 0, -strlen($delim)).$newline;

		// Next blast through the result array and build out the rows
		foreach($array as $row){
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure;
			}
			$out .= implode($delim, $line).$newline;
		}

		return $out;
	}
}

?>
