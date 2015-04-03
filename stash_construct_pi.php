<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Construct Control Panel Class
 *
 * @package    Stash_construct_pi
 * @author     TJ Draper <tj@buzzingpixel.com>
 * @link       https://buzzingpixel.com/ee-add-ons/construct
 * @copyright  Copyright (c) 2015, BuzzingPixel
 */
 class Stash_construct_pi extends Mustash_plugin {

 	/**
 	 * Stash Plugin Name
 	 *
 	 * @var 	string
 	 * @access 	public
 	 */
 	public $name = 'Construct';

 	/**
 	 * Stash Plugin Version
 	 *
 	 * @var 	string
 	 * @access 	public
 	 */
 	public $version = '1.0.0';

 	/**
 	 * Extension hook priority
 	 *
 	 * @var 	integer
 	 * @access 	public
 	 */
 	public $priority = '10';

 	/**
 	 * Extension hooks
 	 *
 	 * @var 	array
 	 * @access 	protected
 	 */
 	protected $hooks = array(
 		'construct_updated',
 	);

 	/**
 	 * Constructor
 	 *
 	 * @return void
 	 */
 	public function __construct()
 	{
 		parent::__construct();
 	}

 	/**
 	 * Set groups for this object
 	 *
 	 * @access	protected
 	 * @return	array
 	 */
 	protected function set_groups()
 	{
 		$trees = $this->_getTrees();

 		return $trees;
 	}

 	/**
 	 * Hook: construct_updated
 	 *
 	 * @access	public
 	 * @param	array (the nodes that were updated)
 	 * @return	void
 	 */
 	public function construct_updated($nodes)
 	{
 		$treeIds = array();

 		foreach ($nodes as $key => $val) {
 			$treeIds[$val['node_tree_id']] = $val['node_tree_id'];
 		}

 		foreach ($treeIds as $val) {
 			$this->flush_cache(__FUNCTION__, $val);
 		}
 	}

 	/**
 	 * Set groups for this object
 	 *
 	 * @access	protected
 	 * @return	array
 	 */
 	private function _getTrees()
 	{
 		$treesQuery = ee()->db
 			->select('tree_id, tree_name')
 			->from('construct_trees')
 			->get();

 		if ($treesQuery->num_rows > 0) {
 			$trees = $treesQuery->result_array();

 			$returnArray = array();

 			foreach ($trees as $key => $val) {
 				$returnArray[$val['tree_id']] = $val['tree_name'];
 			}

 			return $returnArray;
 		}

 		return array();
 	}
 }