<?php

interface markdown_strategy
{


	public static function instance ();


	public function transform ( $text );


}
