<?php

/**
* header.php
*
* File to print out common page header.
* Allows for dynamic title and navbar item changes.
*
* (C) Nick Rabb 2014
*/

/**
* echo_header
*
* Function to print out common page header HTML
*
* !! USER MUST BE LOGGED IN TO USE THIS HEADER !!
*
* @param string $title : The title of the page to print out
* @param boolean $back_vis : Is the back button visible in this header?
* @param string $txt_modifier : A string to append to the 'navbar-title' css style
*			e.g. '-sm', '-md', '-lg'
*/
function echo_header($title, $back_vis=false, $back_url='./index.php', $txt_modifier=''){

	// So session starts don't overlap
	if(session_id() != null){

		echo '<div id="topNav_mobile">
				<div class="row blue">
					<div class="col-xs-8 col-sm-8" style="margin-left: 5%;">
						<h4 class="white ptsans">Welcome, ' . $_SESSION["dive_trainer"]["fname"] . '!</h4>
					</div>
					<div class="col-sm-offset-1 col-xs-offset-1">
						<a href="#" onclick="logOut();"><p style="margin-top: 8px; color: #fff;">Log Out</p></a>
					</div>
				</div>

				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							' . ($back_vis ? '<a href="' . $back_url . '"><span class="glyphicon 
								glyphicon-chevron-left back-arrow"></span></a>' : '') . '
							<p class="navbar-title' . $txt_modifier . '">' . $title . '</p>
						</div>			
					</div>
				</nav>
			</div>
			<div id="topNav_tablet">
				<div class="row blue">
					<div class="col-md-10" style="margin-left: 20px;">
						<h4 class="white ptsans">Welcome, ' . $_SESSION["dive_trainer"]["fname"] . '!</h4>
					</div>
					<div class="col-md-offset-1">
						<a href="#" onclick="logOut();"><p style="margin-top: 8px; color: #fff;">Log Out</p></a>
					</div>
				</div>

				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<p class="navbar-title">' . $title . '</p>
						</div>			
					</div>
				</nav>
			</div>';
	}
}

?>