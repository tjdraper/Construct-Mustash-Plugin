<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Construct Mustash plugin
 *
 * @package Stash_construct_pi
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/construct
 * @copyright Copyright (c) 2015, BuzzingPixel
 */
class Stash_construct_pi extends Mustash_plugin
{
	public $name = 'Construct';
	public $version = '1.0.1';
	public $priority = '10';
	protected $hooks = array(
		'construct_updated',
	);

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Set groups for this object
	 *
	 * @access protected
	 * @return array
	 */
	protected function set_groups()
	{
		$trees = $this->getTrees();

		return $trees;
	}

	/**
	 * Hook: construct_updated
	 *
	 * @access public
	 * @param array (the nodes that were updated)
	 * @return void
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
	 * @access private
	 * @return array
	 */
	private function getTrees()
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