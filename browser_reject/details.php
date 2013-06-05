<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Browser_reject extends Module
{
	public $version = "1.0.0";
	
	public function __construct()
	{	
		parent::__construct();
		
		//Load language
		$this->lang->load('browser_reject/browser_reject');
		
	}
	
	public function info()
	{
		return array(
			'name' => array(
				'it' => "Blocca Browser",
				'en' => "Browser reject"
			),
			'description' => array(
				'it' => "Impedisci o limita l'accesso al tuo sito ai browser selezionati",
				'en' => "Block or limit site access to particular browsers"
			),
			'backend' => true,
			'fontend' => false,
			'menu' => 'content',
			'sections' => array(
				'settings' => array(
					'name' => 'browser_reject:settings',
					'uri' => 'admin/browser_reject'
				),
			),
		);
	}
	
	public function install()
	{
		//Load Streams
		$this->load->driver('Streams');		
		
		//Try to add new streams
		if ( ! $this->streams->streams->add_stream(lang('browser_reject:stream_name'), 'browser_reject', 'browser_reject', '', null)) 
			return false;
			
		$fields = array(
			array(
				'name' => lang('browser_reject:header'),
                'slug' => 'header',
                'namespace' => 'browser_reject',
                'type' => 'text',
                'extra' => array('max_length' => 250),
                'instructions' => lang('browser_reject:header_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => true,
                'unique' => false
			),		
			array(
				'name' => lang('browser_reject:paragraph1'),
                'slug' => 'paragraph1',
                'namespace' => 'browser_reject',
                'type' => 'textarea',
                'instructions' => lang('browser_reject:paragraph1_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => true,
                'unique' => false
			),		
			array(
				'name' => lang('browser_reject:paragraph2'),
                'slug' => 'paragraph2',
                'namespace' => 'browser_reject',
                'type' => 'textarea',
                'instructions' => lang('browser_reject:paragraph2_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
			array(
				'name' => lang('browser_reject:allow_close'),
                'slug' => 'allow_close',
                'namespace' => 'browser_reject',
                'type' => 'choice',
                'extra' => array( 'choice_type'=> 'dropdown', 'default_value'=> 'true', 'choice_data'=> "true : lang:browser_reject:true\nfalse : lang:browser_reject:false" ),
                'instructions' => lang('browser_reject:allow_close_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => true,
                'unique' => false
			),			
			array(
				'name' => lang('browser_reject:close_message'),
                'slug' => 'close_message',
                'namespace' => 'browser_reject',
                'type' => 'text',
                'extra' => array('max_length' => 250),
                'instructions' => lang('browser_reject:close_message_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:close_link_message'),
                'slug' => 'close_link_message',
                'namespace' => 'browser_reject',
                'type' => 'text',
                'extra' => array('max_length' => 250),
                'instructions' => lang('browser_reject:close_link_message_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => true,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:allow_close_esc'),
                'slug' => 'allow_close_esc',
                'namespace' => 'browser_reject',
                'type' => 'choice',
                'extra' => array( 'choice_type'=> 'dropdown', 'default_value'=> 'true', 'choice_data'=> "true : lang:browser_reject:true\nfalse : lang:browser_reject:false" ),
                'instructions' => lang('browser_reject:allow_close_esc_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:use_cookie'),
                'slug' => 'use_cookie',
                'namespace' => 'browser_reject',
                'type' => 'choice',
                'extra' => array( 'choice_type'=> 'dropdown', 'default_value'=> 'false', 'choice_data'=> "true : lang:browser_reject:true\nfalse : lang:browser_reject:false" ),
                'instructions' => lang('browser_reject:use_cookie_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:cookie_expire'),
                'slug' => 'cookie_expire',
                'namespace' => 'browser_reject',
                'type' => 'integer',
                'extra' => array('default_value'=> 0),
                'instructions' => lang('browser_reject:cookie_expire_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:include_jquery'),
                'slug' => 'include_jquery',
                'namespace' => 'browser_reject',
                'type' => 'choice',
                'extra' => array( 'choice_type'=> 'dropdown', 'default_value'=> 'false', 'choice_data'=> "true : lang:browser_reject:true\nfalse : lang:browser_reject:false" ),
                'instructions' => lang('browser_reject:include_jquery_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => true,
                'unique' => false
			),
			
			array(
				'name' => lang('browser_reject:not_allowed'),
                'slug' => 'not_allowed',
                'namespace' => 'browser_reject',
                'type' => 'choice',
                'extra' => array( 'choice_type'=> 'checkboxes', 'choice_data'=> "safari : Safari\nfirefox : Firefox\nchrome : Chrome\nmsie : Microsoft Internet Explorer\nopera : Opera\ndefault : IE < 7", 'default_value' => "default" ),
                'instructions' => lang('browser_reject:not_allowed_instr'),
                'assign' => 'browser_reject',
                'title_column' => true,
                'required' => false,
                'unique' => false
			),
		);
		
		//Add Fields to the Stream
		$this->streams->fields->add_fields($fields);
		
		//Done
		return true;
	}
	
	public function uninstall()
	{
		//Load Streams
		$this->load->driver('Streams');
		
		//Remove streams
		$this->streams->utilities->remove_namespace('browser_reject');
		
		//Drop tables
		$this->dbforge->drop_table('browser_reject');
		
		//Done
		return true;
	}
	
	public function upgrade($old)
	{
		return true;
	}
	
	public function help()
	{
		return "";
	}
}