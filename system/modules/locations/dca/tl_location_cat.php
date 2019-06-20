<?php

/**
 * Locations - Rep Location Plugin for Contao
 *
 * Copyright (C) 2019 Mark St. Jean
 *
 * @package    asconsulting/locations
 * @link       http://andrewstevens.consulting
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

 
/**
 * Table tl_location
 */
$GLOBALS['TL_DCA']['tl_location_cat'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'ctable'					  => array('tl_location').
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'title' => 'index'
            )
        )
    ),
 
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('state', 'name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('name', 'address', 'city', 'state'),
            'format'                  => '%s (%s %s, %s)'
        ),
        'global_operations' => array
        (
            'export' => array
            (
                'label'               => 'Export Locations CSV',
                'href'                => 'key=exportLocations',
                'icon'                => 'system/modules/locations/assets/icons/file-export-icon-16.png'
            ),
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )

        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location_cat']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location_cat']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location_cat']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_location_cat']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Asc\Backend\Locations', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location_cat']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{location_legend},title,description;'
    ),
 
    // Fields
    'fields' => array
    (
	
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location_cat']['title'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location_cat']['description'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr w50'),
			'sql'                     => "text NULL"
		)	
    )
);

