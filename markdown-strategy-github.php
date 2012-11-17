<?php

require_once dirname( __FILE__ ) . '/markdown-strategy.php';
require_once dirname( __FILE__ ) . '/markdown-strategy-default.php';

class markdown_strategy_github extends markdown_strategy_default implements markdown_strategy
{


	private static $instance;


	public static function instance ()
	{
		if ( !isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


}
