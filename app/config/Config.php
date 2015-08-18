<?php

	/**
	* 	Configs
	* 	Class to centralize all configurations of project
	* 	Author: Diogo Cezar Teixeira Batista
	*	Year: 2015 
	*/

	class Configs{
		public static $configs = array(
									   'FB' => array(
													   'APP_ID'			=> '',
													   'APP_SECRET'		=> '',
													   'GRAP_VERSION'   => 'v2.2',
													   'CALLBACK'       => '',
													   'PERMISSIONS'    => array('email',
													   	                         'user_friends',
													   	                         'user_birthday',
													   	                         'user_hometown',
													   	                         'user_likes',
													   	                         'user_location',
													   	                         'user_website',
													   	                         'user_about_me'
													   	                   )
												 ),
									);
	}
?>
