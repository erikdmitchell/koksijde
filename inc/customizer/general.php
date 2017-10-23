<?php

function koksijde_display_home_content() {
	if (get_theme_mod('display_content', 0))
		return true;
		
	return false;
}	
?>