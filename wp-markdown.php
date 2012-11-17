<?php

/**
 * Plugin Name: Markdown Tools
 * Plugin URI: http://greentiedev.com/projects/wp-markdown
 * Description: A set of widgets and shortcodes which provide markdown parsing functionality.
 * Version: 0.1
 * Author: GreenTie Development (AJ Michels)
 * Author URI: http://greentiedev.com
 */

require_once dirname( __FILE__ ) . '/markdown-parser.php';

class wp_markdown
{


	private static $instance;


	private function __construct ()
	{
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}


	public static function instance ()
	{
		if ( !isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	public function register_shortcodes ()
	{
		add_shortcode( 'md', array( $this, 'markdown_shortcode' ) );
	}


	public function markdown_shortcode ( $atts, $content=null )
	{

		return $this->parse_markdown( "#heading\n* test \n* test", 'github' );

		$parsed_content = '';

		if ( array_key_exists( 'url', $atts ) ) {

			$url_hash = 'md-content_' . md5( $atts['url'] );

			if ( ( $parsed_content = get_transient( $url_hash ) ) === false ) {

				$response = wp_remote_get( $atts['url'] );

				if( !is_wp_error( $response ) ) {

					$parsed_content = $this->parse_markdown( $response['body'], ( array_key_exists( 'flav', $atts ) ) ? $atts['flav'] : 'default' );

					set_transient( $url_hash, $parsed_content, 1800 );

				}

			}

		}

		return $parsed_content;

	}


	private function parse_markdown ( $text, $strategy='default' )
	{
		return markdown_parser::transform( $text, $strategy );
	}


}

wp_markdown::instance();
