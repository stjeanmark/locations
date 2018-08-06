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


/**
* Back end modules
*/
$GLOBALS['BE_MOD']['content']['locations'] = array(
	'tables' => array('tl_location'),
	'icon'   => 'system/modules/locations/assets/icons/location.png'
);

/**
* Front end modules
*/
$GLOBALS['FE_MOD']['locations']['locations_list'] 	= 'Asc\Module\LocationsList';

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_location'] = 'Asc\Model\Location';