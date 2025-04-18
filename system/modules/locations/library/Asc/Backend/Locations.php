<?php

/**
 * Locations - Location Plugin for Contao
 *
 * Copyright (C) 2018 Andrew Stevens
 *
 * @package    asconsulting/locations
 * @link       http://andrewstevens.consulting
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

 
namespace Asc\Backend;

use Contao\DataContainer;
use Asc\Model\Location;
use Asc\Model\Category;

class Locations extends \Backend
{

	public function getItemTemplates()
	{
		return $this->getTemplateGroup('item_location');
	}

	
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
	}	
	

	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_location']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_location']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_location SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->log('A new version of record "tl_location.id='.$intId.'" has been created'.$this->getParentEntries('tl_location', $intId), __METHOD__, TL_GENERAL);
	}
	
	
	
	// Export the Rep Locations in CSV format
	public function exportLocations()
	{
	    // Get all of the Location data in the system
		$objLocation = Location::findAll();
		// What separates the data into columns
		$strDelimiter = ',';
		// What wraps the data, used to help with data containing commas
		$strDataWrapper = '"';
	   
        // If we found at least one Location
		if ($objLocation) {
		    
		    // Build the export's filename, in this case it is "locations_" and the date
			$strFilename = "locations_" .(date('Y-m-d_Hi')) .".csv";
			
			// Create a new 'temporary file' in memory that will hold our CSV until we save
			$tmpFile = fopen('php://memory', 'w');
			
			// Tracks loops so we can do things differently for the first line
			$count = 0;
			// Loop through our gathered Location data
			while($objLocation->next()) {
			    // Save this rows data as a php array
				$row = $objLocation->row();
				
				// Unset the 'zip' data from this array
				unset($row["zip"]);
				
				// Convert PID to Category and remove PID
				$row['category'] = $row['pid'];
				unset($row["pid"]);
				
				// Convert Category from serialized array to strings
				$categories_buffer = '';
				$categories = unserialize($row['category']);
				$first = true;
				foreach($categories as $cat_id) {
				    $cat = Category::findBy(['id = ?'], [$cat_id]);
				    
				    if($first){
				        $first = false;
				        $categories_buffer .= $cat->name;
				    } else 
				        $categories_buffer .= ', ' . $cat->name;
				}
				$row['category'] = $categories_buffer;
				
				
				// If this is our first loop run
				if ($count == 0) {
					$arrColumns = array();
					foreach ($row as $key => $value) {
						
						$arrColumns[] = $key;
					}
					fputcsv($tmpFile, $arrColumns, $strDelimiter, $strDataWrapper);
				}
				$count ++;
				fputcsv($tmpFile, $row, $strDelimiter);
			}
			
			fseek($tmpFile, 0);
			
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $strFilename . '";');
			fpassthru($tmpFile);
			exit();
			
		} else {
			return "Nothing to export";
		}
	}
	
	
	
	
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;
		
		// Generate an alias if there is none
		if ($varValue == '')
		{
			$autoAlias = true;
			$varValue = standardize(\StringUtil::restoreBasicEntities($dc->activeRecord->name));
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_location WHERE id=? OR alias=?")
								   ->execute($dc->id, $varValue);

		// Check whether the page alias exists
		if ($objAlias->numRows > 1)
		{
			if (!$autoAlias)
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
			}

			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}
	
	public function getStates() {
		return array(
			'United States' => array(
				'AL' => 'Alabama',
				'AK' => 'Alaska',
				'AZ' => 'Arizona',
				'AR' => 'Arkansas',
				'CA' => 'California',
				'CO' => 'Colorado',
				'CT' => 'Connecticut',
				'DE' => 'Delaware',
				'FL' => 'Florida',
				'GA' => 'Georgia',
				'HI' => 'Hawaii',
				'ID' => 'Idaho',
				'IL' => 'Illinois',
				'IN' => 'Indiana',
				'IA' => 'Iowa',
				'KS' => 'Kansas',
				'KY' => 'Kentucky',
				'LA' => 'Louisiana',
				'ME' => 'Maine',
				'MD' => 'Maryland',
				'MA' => 'Massachusetts',
				'MI' => 'Michigan',
				'MN' => 'Minnesota',
				'MS' => 'Mississippi',
				'MO' => 'Missouri',
				'MT' => 'Montana',
				'NE' => 'Nebraska',
				'NV' => 'Nevada',
				'NH' => 'New Hampshire',
				'NJ' => 'New Jersey',
				'NM' => 'New Mexico',
				'NY' => 'New York',
				'NC' => 'North Carolina',
				'ND' => 'North Dakota',
				'OH' => 'Ohio',
				'OK' => 'Oklahoma',
				'OR' => 'Oregon',
				'PA' => 'Pennsylvania',
				'RI' => 'Rhode Island',
				'SC' => 'South Carolina',
				'SD' => 'South Dakota',
				'TN' => 'Tennessee',
				'TX' => 'Texas',
				'UT' => 'Utah',
				'VT' => 'Vermont',
				'VA' => 'Virginia',
				'WA' => 'Washington',
				'WV' => 'West Virginia',
				'WI' => 'Wisconsin',
				'WY' => 'Wyoming',
				'AS' => 'American Samoa',
				'DC' => 'District of Columbia',
				'FM' => 'Federated States of Micronesia',
				'GU' => 'Guam',
				'MH' => 'Marshall Islands',
				'MP' => 'Northern Mariana Islands',
				'PW' => 'Palau',
				'PR' => 'Puerto Rico',
				'VI' => 'Virgin Islands'),
			'Canada' => array(
				'AB' => 'Alberta',
				'BC' => 'British Columbia',
				'MB' => 'Manitoba',
				'NB' => 'New Brunswick',
				'NL' => 'Newfoundland and Labrador',
				'NS' => 'Nova Scotia',
				'NT' => 'Northwest Territories',
				'NU' => 'Nunavut',
				'ON' => 'Ontario',
				'PE' => 'Prince Edward Island',
				'QC' => 'Quebec',
				'SK' => 'Saskatchewan',
				'YT' => 'Yukon')
			);
	}
	
	public function getCategories() { 
		$cats = array();
		$this->import('Database');
		$result = $this->Database->prepare("SELECT * FROM tl_category WHERE published=1")->execute();
		while($result->next())
		{
			$cats = $cats + array($result->id => $result->name);
		}
		return $cats;
		
		
		#return array(
		#	'1' => 'Onee',
		#	'2' => 'Twoo',
		#	'3' => 'Threee',
		#	'4' => 'Fourr'
		#);
	}
	
}
