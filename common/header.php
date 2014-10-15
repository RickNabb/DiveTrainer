<?php

/**
* header.php
*
* File to print out common page header.
* Allows for dynamic title change.
*
* (C) Nick Rabb 2014
*/

/**
* echo_header
*
* Function to print out common page header HTML
*
* @param string $title : The title of the page to print out
*/
function echo_header($title){

	// So session starts don't overlap
	if(session_id() == null)
		session_start();

	echo' <div class="topNav">
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
						<p class="navbar-title">' . $title . '</p>
					</div>			
				</div>
			</nav>
		</div>';
}

?>