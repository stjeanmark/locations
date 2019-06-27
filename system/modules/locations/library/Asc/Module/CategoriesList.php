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
use Asc\Categories; 
 
class CategoriesList extends \Contao\Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_categories_list';
 
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
		$this->arrStates = Categories::getCategories();
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
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['categories_list'][0]) . ' ###';
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
		$objCategory = Category::findBy('published', '1');
		
		if (!in_array('system/modules/locations/assets/js/categories.js', $GLOBALS['TL_JAVASCRIPT'])) { 
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/locations/assets/js/categories.js';
		}
		
		// Return if no pending items were found
		if (!$objCategory)
		{
			$this->Template->empty = 'No Categories Found';
			return;
		}

		$arrCategories = array();
		
		// Generate List
		while ($objCategory->next())
		{
			$strCategoryKey = $objCategory->category;
			$strCategoryName = ($this->arrCategories["Categories"][$objCategory->category] != '' ? $this->arrCategories["Categories"][$objCategory->category] : $this->arrCategories["Canada"][$objCategory->category]);
			if (in_array($objCategory->category, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strCategoryKey = 'CAN';
				$strCategoryName = 'Canada - All Provinces';
			}
			
			if (!array_key_exists($strCategoryKey, $arrCategories)) {
				$arrCategories[$strCategoryKey] = array(
					"name" 			=> $strCategoryName,
					"abbr"			=> $strCategoryKey,
					"locations"		=> array()
				);
			}
			
			$arrLocation = array(
				'id'		=> $objCategory->id,
				'pid'       => $objCategory->pid,
				'alias'		=> $objCategory->alias,
				'tstamp'	=> $objCategory->tstamp,
				'timetamp'	=> \Date::parse(\Config::get('datimFormat'), $objCategory->tstamp),
				'published' => $objCategory->published
			);
			
			if ($this->jumpTo) {
				$objTarget = $this->objModel->getRelated('jumpTo');
				$arrLocation['link'] = $this->generateFrontendUrl($objTarget->row()) .'?alias=' .$objCategory->alias;
			}
			
			$arrLocation['pid'] 	= $objCategory->pid;
			$arrLocation['name'] 	= $objCategory->name;
			$arrLocation['address'] = $objCategory->address;
			$arrLocation['city'] 	= $objCategory->city;
			$arrLocation['state'] 	= $objCategory->state;
			$arrLocation['zip'] 	= $objCategory->zip;
			$arrLocation['country'] = $objCategory->country;
			$arrLocation['phone'] 	= $objCategory->phone;
			$arrLocation['url'] 	= $objCategory->url;

			$strItemTemplate = ($this->locations_customItemTpl != '' ? $this->locations_customItemTpl : 'item_location');
			$objTemplate = new \FrontendTemplate($strItemTemplate);
			$objTemplate->setData($arrLocation);
			$arrCategories[$strCategoryKey]['locations'][] = $objTemplate->parse();
		}

		$arrTemp = $arrCategories;
		unset($arrTemp['CAN']);
		uasort($arrTemp, array($this,'sortByCategory'));
		$arrTemp['CAN'] = $arrCategories['CAN'];
		$arrCategories = $arrTemp;
		
		$this->Template->categoryOptions = $this->generateSelectOptions();
		$this->Template->categories = $arrCategories;
		
	}

	public function generateSelectOptions($blank = TRUE) {
		$strUnitedStates = '<optgroup label="Categories">';
		$strCanada = '<optgroup label="Canada"><option value="CAN">All Provinces</option></optgroup>';
		foreach ($this->arrStates['Categories'] as $abbr => $state) {
			if (!in_array($objCategory->category, array('AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT'))) {
				$strUnitedStates .= '<option value="' .$abbr .'">' .$category .'</option>';
			}
		}
		$strUnitedStates .= '</optgroup>';
		return ($blank ? '<option value="">Select Location...</option>' : '') .$strUnitedStates .$strCanada;
	}
	
	function sortByCategory($a, $b) {
		if ($a['Name'] == $b['Name']) {
			return 0;
		}
		return ($a['Name'] < $b['Name']) ? -1 : 1;
	}
	
} 
