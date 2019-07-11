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

 
namespace Asc;

use Asc\Model\Location;

/**
 * Class Asc\Locations
 */
class Locations {
	
	public function getCategories()
    {		
        return array(
			'1' => 'Onee',
			'2' => 'Twoo',
			'3' => 'Threee',
			'4' => 'Fourr',
			);
    }
}