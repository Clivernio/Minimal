<?php
/**
 * Min - Minimal WordPress Theme
 *
 * @author      Clivern <hello@clivern.com>
 * @copyright   2014 Clivern
 * @link        http://clivern.com
 * @license     GPL
 * @version     1.0
 * @package     Min
 */

class Twitter extends WP_Widget {
	/**
	 * @var array a list of widget settings
	 */
	private $settings = array(
		'title' => 'Latest Tweet',
		'query' => 'from:clivernco',
		'cache_interval' => '43200',
		'query_type' => 'user_timeline', /* or search */
		'number' => 1,
		'show_follow' => false,
		'show_avatar' => false,
		'show_account' => true,
		'consumer_key' => '',
		'consumer_secret' => '',
		'exclude_replies' => true
	);

	/**
	 * @var array latest tweets data saved in db
	 */
	private $latest_tweet = array(
		'last_check' => '',
		'access_token' => '',
		'tweets' => '',
	);

	/**
	 * @var string code to show follow button
	 */
	private $follow_button = '<a href="https://twitter.com/__name__" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @__name__</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

	/**
	 * Widget constructor function
	 * 
	 * @since 1.0
	 */
	function __construct()
	{
		$widget_ops = array(
		  'classname' => 'dw_twitter latest-twitter',
		  'description' => __('Display latest Tweets from Twitter', 'dw-kido') );

		$this->WP_Widget('clivern_twitter_widget', __('Twitter', 'dw-kido'), $widget_ops);
	}

	/**
	 * Get widget options
	 * 
	 * @since 1.0
	 */
	function get_options()
	{
		$this->latest_tweet = get_option('clivern_twitter_widget');
	}

	/**
	 * Get latest tweets
	 * 
	 * @since 1.0
	 * @return boolean
	 */
	function get_tweets()
	{
		//check if access token is empty
		if ( empty($this->latest_tweet[ 'access_token' ]) ) {
			return false;
		}
		//build remote url
		if ( $this->settings[ 'query_type' ] == 'user_timeline' ) {
			$query = substr($this->settings[ 'query' ], 5);
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . rawurlencode($query) . '&count=' . $this->settings[ 'number' ];
			if ( $this->settings[ 'exclude_replies' ] ) {
				$url .= '&exclude_replies=true';
			}
		}
		else {
			$url = 'https://api.twitter.com/1.1/search/tweets.json?q=' . rawurlencode($query) . '&count=' . $this->settings[ 'number' ];
			if ( $this->settings[ 'exclude_replies' ] ) {
				$url .= '&exclude_replies=true';
			}
		}
		//get data from remote url
		$remote_get_tweets = wp_remote_get($url, array(
		  'headers' => array(
		    'Authorization' => 'Bearer ' . $this->latest_tweet[ 'access_token' ]
		  ),
		  // disable checking SSL sertificates               
		  'sslverify' => false ));
		//decode returned data
		$result = json_decode(wp_remote_retrieve_body($remote_get_tweets));
		//check if returned data not buggy
		if ( empty($result) || (isset($result->errors) && ( $result->errors[ 0 ]->code == 89 || $result->errors[ 0 ]->code == 215 ) ) ) {
			return false;
		}
		//create a var to catch tweets
		$tweets = array();
		if ( 'user_timeline' == $this->settings[ 'query_type' ] ) {
			$tweets = $result;
		}
		else {
			if ( !empty($result->statuses) ) {
				$tweets = $result->statuses;
			}
		}
		if ( !empty($tweets) ) {
			$this->latest_tweet[ 'tweets' ] = array();
			foreach ( $tweets as $tweet ) {
				$this->latest_tweet[ 'tweets' ][] = array(
				  'text' => $this->update_urls($tweet->text),
				  'time' => $tweet->created_at,
				  'url' => 'http://twitter.com/' . $tweet->user->id . '/status/' . $tweet->id_str,
				  'screen_name' => $tweet->user->screen_name,
				  'name' => $tweet->user->name,
				  'profile_image_url' => $tweet->user->profile_image_url,
				);
			}
		}else {
			return false;
		}
		//set last check time
		$this->latest_tweet[ 'last_check' ] = time();
		return true;
	}

	/**
	 * Get access token
	 * 
	 * @since 1.0
	 * @return boolean
	 */
	function get_access_token()
	{
		$consumer_key = rawurlencode($this->settings[ 'consumer_key' ]);
		$consumer_secret = rawurlencode($this->settings[ 'consumer_secret' ]);
		//check if key and secret exist
		if ( empty($consumer_secret) || empty($consumer_key) ) {
			return false;
		}
		//get fresh access token of there is no one
		if ( empty($this->latest_tweet[ 'access_token' ]) ) {
			//build request headers
			$authorization = base64_encode($consumer_key . ':' . $consumer_secret);
			$args = array(
			  'httpversion' => '1.1',
			  'headers' => array(
			    'Authorization' => 'Basic ' . $authorization,
			    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
			  ),
			  'body' => array( 'grant_type' => 'client_credentials' )
			);
			add_filter('https_ssl_verify', '__return_false');
			//process remotes request to get access key
			$remote_get_tweets = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
			//decode results
			$result = json_decode(wp_remote_retrieve_body($remote_get_tweets));
			if ( !isset($result->access_token) ) {
				return false;
			}
			$this->latest_tweet[ 'access_token' ] = $result->access_token;
			return true;
		}
	}

	/**
	 * Update tweets urls
	 * 
	 * @since 1.0
	 * @param string $content
	 * @return string
	 */
	function update_urls($content)
	{
		$maxLen = 16;
		//split long words
		$pattern = '/[^\s\t]{' . $maxLen . '}[^\s\.\,\+\-\_]+/';
		$content = preg_replace($pattern, '$0 ', $content);
		//
		$pattern = '/\w{2,5}\:\/\/[^\s\"]+/';
		$content = preg_replace($pattern, '<a href="$0" title="" target="_blank">$0</a>', $content);
		//search
		$pattern = '/\#([a-zA-Z0-9_-]+)/';
		$content = preg_replace($pattern, '<a href="https://twitter.com/search?q=%23$1&src=hash" title="" target="_blank">$0</a>', $content);
		//user
		$pattern = '/\@([a-zA-Z0-9_-]+)/';
		$content = preg_replace($pattern, '<a href="https://twitter.com/#!/$1" title="" target="_blank">$0</a>', $content);
		return $content;
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

		//extract args
		extract($args);
		//set status to check everything is fine
		$status = false;
		//get current time
		$now = time();
		//get cached data
		$this->get_options();
		//check if last check was too late
		if ( (int) ($now - $this->latest_tweet[ 'last_check' ]) > (int) ($this->settings[ 'cache_interval' ]) ) {
			//get access token
			$access_token_status = $this->get_access_token();
			//get tweets
			$tweets_status = $this->get_tweets();
			//update options
			$this->update_options();
		}
		//check if tweets exist
		if ( empty($this->latest_tweet[ 'tweets' ]) ) {
			//no tweets and error found ignore widget
			echo $before_widget;
			echo $after_widget;
		} else {
			// it is the time to show widget
			echo $before_widget;
			//show widget title
			echo $before_title . $this->settings[ 'title' ] . $after_title;
			echo '<div class="dw-twitter-inner ' . (($this->settings[ 'show_follow' ]) ? 'has-follow-button' : '') . '" >';
			//loop through tweets
			foreach ( $this->latest_tweet[ 'tweets' ] as $key => $tweet ) {
				//show tweets in case of search
				echo '<div class="tweet-item ' . $this->settings[ 'query_type' ] . '">';
				if ( 'search' == $this->settings[ 'query_type' ] ) {
					echo '<div class="twitter-user">';
					if ( $this->settings[ 'show_account' ] ) {
						echo '<a href="https://twitter.com/' . $tweet[ 'screen_name' ] . '" class="user">';
						if ( $this->settings[ 'show_avatar' ] && $tweet[ 'profile_image_url' ] ) {
							echo '<img src="' . $tweet[ 'profile_image_url' ] . '" width="16px" height="16px" >';
						}
						echo '&nbsp;<strong class="name">' . $tweet[ 'name' ] . '</strong>&nbsp;<span class="screen_name">@' . $tweet[ 'screen_name' ] . '</span></a>';
					}
					echo '</div>';
				}

				echo '<div class="tweet-content">' . $tweet[ 'text' ] . ' <span class="time"><a target="_blank" title="" href="' . $tweet[ 'url' ] . '"> about ' . human_time_diff( strtotime($tweet[ 'time' ]), time() ). ' ago</a></span></div>';
				if ( 'search' == $this->settings[ 'query_type' ] ) {
					if ( $this->settings[ 'show_follow' ] ) {
						echo str_replace('__name__', $tweet[ 'screen_name' ], $this->follow_button);
					}
				}
				echo '</div>';
			}
			//show tweets in case of user timeline
			if ( 'user_timeline' == $this->settings[ 'query_type' ] ) {
				echo '<div class="twitter-user">';
				if ( $this->settings[ 'show_account' ] ) {
					echo '<a href="https://twitter.com/' . $this->latest_tweet[ 'tweets' ][0][ 'screen_name' ] . '" class="user">';
					if ( $this->settings[ 'show_avatar' ] && $this->latest_tweet[ 'tweets' ][0][ 'profile_image_url' ] ) {
						echo '<img src="' . $this->latest_tweet[ 'tweets' ][0][ 'profile_image_url' ] . '" width="16px" height="16px" >';
					}
					echo '&nbsp;<strong class="name">' . $this->latest_tweet[ 'tweets' ][0][ 'name' ] . '</strong>&nbsp;<span class="screen_name">@' . $this->latest_tweet[ 'tweets' ][0][ 'screen_name' ] . '</span></a>';
				}
				if ( $this->settings[ 'show_follow' ] ) {
					echo str_replace('__name__', $this->latest_tweet[ 'tweets' ][0][ 'screen_name' ], $this->follow_button);
				}
				echo '</div>';
			}
			echo '</div>';
			echo $after_widget;
		}
	}

	/**
	 * Update widget options
	 * 
	 * @since 1.0
	 * @return boolean
	 */
	function update_options()
	{
		return update_option('clivern_twitter_widget', $this->latest_tweet);
	}

}
