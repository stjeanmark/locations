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

  
namespace Asc\Module;
 
use Asc\Model\Category;
use Asc\Model\Location;
use Asc\Locations; 
 
class LocationsList extends \Contao\Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_locations_list';
 
	protected $arrStates = array();
 
	/**
	 * Initialize the object
	 *
	 * @param \ModuleModel $objModule
	 * @param string       $strColumn
	 */
	public function __construct($objModule, $strColumn='main')
	{
		parent::__construct($objModule, $strColumn);
		$this->arrStates = $this->getStates();
	}
	
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['locations_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
 
            return $objTemplate->parse();
        }
 
        return parent::generate();
    }
 
 
    /**
     * Generate the module
     */
    protected function compile()
    {
		$objLocation = Location::findBy('published', '1');
		
		if (!in_array('system/modules/locations/assets/js/locations.js', $GLOBALS['TL_JAVASCRIPT'])) { 
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/locations/assets/js/locations.js';
		}
		
		// Return if no pending items were found
		if (!$objLocation)
		{
			$this->Template->empty = 'No Locations Found';
			return;
		}

		$arrStates = array();
		
		// Generate List
		while ($objLocation->next())
		{
			$strStateKey = $objLocation->state;
			$strStateName = ($this->arrStates["United States"][$objLocation->state] != '' ? $this->arrStates["United States"][$objLocation->state] : $this->arrStates["Canada"][$objLocation->state]);
			if (in_array($objLocation->state, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strStateKey = 'CAN';
				$strStateName = 'Canada - All Provinces';
			}
			
			if (!array_key_exists($strStateKey, $arrStates)) {
				$arrStates[$strStateKey] = array(
					"name" 			=> $strStateName,
					'pid'			=> $objLocation->pid,
					"abbr"			=> $strStateKey,
					"locations"		=> array()
				);
			}
			
			$arrLocation = array(
				'id'		=> $objLocation->id,
				'pid'		=> $objLocation->pid,
				'alias'		=> $objLocation->alias,
				'tstamp'	=> $objLocation->tstamp,
				'timetamp'	=> \Date::parse(\Config::get('datimFormat'), $objLocation->tstamp),
				'published' => $objLocation->published
			);
			
			if ($this->jumpTo) {
				$objTarget = $this->objModel->getRelated('jumpTo');
				$arrLocation['link'] = $this->generateFrontendUrl($objTarget->row()) .'?alias=' .$objLocation->alias;
			}
			
			//$this->Template->categories = \StringUtil::deserialize(YOUR_VARIABLE_HERE);
			
			$arrLocation['pid'] 			= \StringUtil::deserialize($objLocation->pid);
			$arrLocation['name'] 			= $objLocation->name;
			$arrLocation['contact_name']		= $objLocation->contact_name;
			$arrLocation['contact_name_2']		= $objLocation->contact_name_2;
			$arrLocation['contact_name_3']		= $objLocation->contact_name_3;
			$arrLocation['address']	 		= $objLocation->address;
			$arrLocation['address_2']	 	= $objLocation->address_2;
			$arrLocation['city'] 			= $objLocation->city;
			$arrLocation['state'] 			= $objLocation->state;
			$arrLocation['zip'] 			= $objLocation->zip;
			$arrLocation['listing_zip']		= $objLocation->listing_zip;

			$arrLocation['territory']       = $objLocation->territory;
			
			$arrLocation['country'] 		= $objLocation->country;
			$arrLocation['phone'] 			= $objLocation->phone;
			$arrLocation['url'] 			= $objLocation->url;

			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_location');
			$objTemplate = new \FrontendTemplate($strItemTemplate);
			$objTemplate->setData($arrLocation);
			$arrStates[$strStateKey]['locations'][] = $objTemplate->parse();
		}

		$arrTemp = $arrStates;
		unset($arrTemp['CAN']);
		uasort($arrTemp, array($this,'sortByState'));
		$arrTemp['CAN'] = $arrStates['CAN'];
		$arrStates = $arrTemp;
		
		$this->Template->stateOptions = $this->generateSelectOptions();
	    	$this->Template->stateFilter = $this->generateStateFilter();
		$this->Template->states = $arrStates;

	    	$categories = Category::findBy('published', '1');
		
		$our_cats = array();
		foreach($categories as $category) {
		    $our_cats[$category->id] = $category->name;
		}
		
		$this->Template->categories = $our_cats;
		
	}

	public function generateSelectOptions($blank = TRUE) {
		$strUnitedStates = '<optgroup label="United States">';
		$strCanada = '<optgroup label="Canada"><option value="CAN">All Provinces</option></optgroup>';
		foreach ($this->arrStates['United States'] as $abbr => $state) {
			if (!in_array($objLocation->state, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strUnitedStates .= '<option value="' .$abbr .'">' .$state .'</option>';
			}
		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Select Location...</option>' : '') .$strUnitedStates .$strCanada;
	}

	public function generateStateFilter($blank = TRUE) {
		$strUnitedStates = '<optgroup label="United States">';
		$strCanada = '<optgroup label="Canada"><option value="CAN">All Provinces</option></optgroup>';
		foreach ($this->arrStates['United States'] as $abbr => $state) {
			if (!in_array($objLocation->state, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strUnitedStates .= '<option value="' .$abbr .'">' .$state .'</option>';
			}
		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Choose a State...</option>' : '') .$strUnitedStates .$strCanada;
	}
	
	function sortByState($a, $b) {
		if ($a['Name'] == $b['Name']) {
			return 0;
		}
		return ($a['Name'] < $b['Name']) ? -1 : 1;
	}
	
	public function getStates()
    {		
        return array(
			"United States" => array(
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
			"Canada" => array(
				"CAN" => "All Provinces")
			);
    }

} 
