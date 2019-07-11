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
 * Table tl_location
 */
$GLOBALS['TL_DCA']['tl_location'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' 	=> 	'primary',
                'pid' 	=> 	'index',
                'alias' =>  'index'
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
                'label'               => &$GLOBALS['TL_LANG']['tl_location']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
			
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_location']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Asc\Backend\Locations', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_location']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{location_legend},name,alias;{address_legend},address,city,state,zip,phone;{category_legend},pid;{website_legend},url;{publish_legend},published;'
    ),
 
    // Fields
    'fields' => array
    (
	
	
	
	$GLOBALS['TL_DCA']['tl_page']['fields']['firebug_options'] = array 
( 
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['firebug_options'],  
    'inputType'               => 'checkbox', 
    'options'                  => array 
                                    ( 
                                        'saveCookies', 
                                        'startOpened', 
                                        'startInNewWindow', 
                                        'showIconWhenHidden', 
                                        'overrideConsole', 
                                        'ignoreFirebugElements', 
                                        'disableXHRListener', 
                                        'disableWhenFirebugActive', 
                                        'enableTrace', 
                                        'enablePersistent' 
                                    ), 
    'default'                  => array('showIconWhenHidden','disableWhenFirebugActive'),         
    'eval'                    => array('multiple'=>true, 'tl_class'=>'clr') 
);  
	
	
	
	
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
		
		'pid' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL",
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['categories'],
			'inputType'               => 'checkbox', 
			'options'                  => array 
											( 
												'1', 
												'2'
											), 
			'default'                  => array('1'),         
			'eval'                    => array('multiple'=>false, 'tl_class'=>'clr') 
			
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Asc\Backend\Locations', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'address' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['address'],
			'inputType'               => 'text',
			'default'				  => '',
			'eval'                    => array('tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'city' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['city'],
			'inputType'               => 'text',
			'default'				  => '',
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'state' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['state'],
			'inputType'               => 'select',
			'default'				  => '',
			'options_callback'		  => array('Asc\Backend\Locations', 'getStates'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'zip' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['zip'],
			'inputType'               => 'text',
			'default'				  => '',
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'phone' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['phone'],
			'inputType'               => 'text',
			'default'				  => '',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['url'],
			'inputType'               => 'text',
			'default'				  => '',
			'eval'                    => array('tl_class'=>'clr w50', 'rgxp'=>'url'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'published' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_location']['published'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		)		
    )
);

