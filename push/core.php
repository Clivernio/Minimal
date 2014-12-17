<?php
/**
 * Min. - Minimal WordPress Theme
 *
 * @author      Clivern <hello@clivern.com>
 * @copyright   2014 Clivern
 * @link        http://clivern.com
 * @license     GPL
 * @version     1.0
 * @package     Ant
 */

class Core {
	
	/**
       * Holds an instance of this class
       * 
       * @since 1.0
       * @access private
       * @var object self::$instance
       */
	private static $instance;

	/**
	 * Create instance of this class or return existing instance
	 *
	 * @since 1.0
	 * @access public
	 * @return object an instance of this class
	 */
	public static function instance()
	{
		if ( !isset(self::$instance) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}	
}