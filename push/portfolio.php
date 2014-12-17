<?php
/**
 * Ant - Minimal WordPress Theme
 *
 * @author      Clivern <hello@clivern.com>
 * @copyright   2014 Clivern
 * @link        http://clivern.com
 * @license     GPL
 * @version     1.0
 * @package     Ant
 */

class Portfolio extends WP_Widget
{

      /**
       * Widget title
       * 
       * @var string $this->title
       */
      private $title = 'Portfolio';

      /**
       * Follow URL
       * 
       * @var string $this->title
       */
      private $follow = 'http://codecanyon.net/user/clivern';

      /**
       * Portfolio Items
       * 
       * @var array $this->items
       */
      private $items = array(
      	'accountant' => array(
                  'thumb' => 'http://clivern.com/temp/accountant-ico.png',
                  'title' => 'Accountant - Store Accounting System',
                  'link' => 'http://clivern.com/portfolio/accountant/'
                  ),
      	'bottle' => array(
                  'thumb' => 'http://clivern.com/temp/bottle-ico.png',
                  'title' => 'Bottle - Wordpress Files Pocket',
                  'link' => 'http://clivern.com/portfolio/bottle/'
                  ),
      	'bits' => array(
                  'thumb' => 'http://clivern.com/temp/bits-ico.png',
                  'title' => 'Bits - Modern Syntax Highlighter',
                  'link' => 'http://clivern.com/portfolio/bits/'
                  ),
      	'diker' => array(
                  'thumb' => 'http://clivern.com/temp/diker-ico.png',
                  'title' => 'Diker - Online Surveys WordPress Plugin',
                  'link' => 'http://clivern.com/portfolio/diker/'
                  )
      	);

      /**
       * Widget constructor function
       * 
       * @since 1.0
       */
      function Portfolio()
      {
            $widget_ops = array(
              'classname' => 'clivern_portfolio_class',
              'description' => __('Display My Portfolio Items Thumbnails', 'dw-kido') );

            $this->WP_Widget('clivern_portfolio', __('Portfolio', 'dw-kido'), $widget_ops);
      }

      /**
       * Show widget in front end
       *
       * @since 1.0
       * @param array $args
       * @param array $instance
       */
      function widget($args, $instance)
      {
            extract($args, EXTR_SKIP);

            echo $before_widget;
            if(!empty($this->title)) { echo $before_title . $this->title . $after_title; };
            echo "<ul class='instagram-pics'>";
            foreach ($this->items as $item) {
                  echo "<li><a href='{$item['link']}'><img src='{$item['thumb']}' alt='{$item['title']}' title='{$item['title']}'></a></li>";
            }
            echo "</ul>";
            if(!empty($this->follow)){
                  echo "<p class='clear'><a href='{$this->follow}' rel='external nofollow' target='__blank'>Follow Me</a></p>";
            }
            echo $after_widget;
      }

}