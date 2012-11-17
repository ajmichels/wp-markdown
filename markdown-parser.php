<?php

class markdown_parser
{


	/* PROPERTIES ******************************************************************************* */

	private static $instance;
	private static $strategies = array();


	/* PUBLIC METHODS *************************************************************************** */

	public static function transform ( $text, $strategy='default' )
	{
		if ( !array_key_exists( $strategy, self::$strategies ) ) {
			switch ( $strategy ) {

				case 'github':
					require_once dirname( __FILE__ ) . '/markdown-strategy-github.php';
					self::addStrategy( $strategy, markdown_strategy_github::instance() );
					break;

				default:
					require_once dirname( __FILE__ ) . '/markdown-strategy-default.php';
					self::addStrategy( $strategy, markdown_strategy_default::instance() );
					break;

			}
		}
		return self::getStrategy( $strategy )->transform( $text );
	}


	/* ACCESSOR METHODS ************************************************************************* */

	public  function getStrategy ( $key )
	{
		return self::$strategies[$key];
	}


	public function addStrategy ( $key, markdown_strategy $strategy )
	{
		self::$strategies[$key] = $strategy;
	}


}
