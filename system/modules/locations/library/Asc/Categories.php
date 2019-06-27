<?php

/**
 * Categories - Location Plugin for Contao
 *
 * Copyright (C) 2018 Andrew Stevens
 *
 * @package    asconsulting/locations
 * @link       http://andrewstevens.consulting
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

 
namespace Asc;

use Asc\Model\Category;

/**
 * Class Asc\Categories
 */
class Categories {
	
	public function getCategories()
    {		
        return array(
			"Categories" => array(
				'AR' => 'Architetual',
				'HV' => 'HVAC',
				'IN' => 'Industrial',
				'ME' => 'Medical')
			);
    }
}