foo
function koksijde_slider_indicators() {
	global $koksijde_slider_config;

	if (!count($koksijde_slider_config['posts']) || !$koksijde_slider_config['indicators'])
		return false;

	$html=null;
	$counter=0;

	$html.='<ol class="carousel-indicators">';
		foreach ($koksijde_slider_config['posts'] as $post) :
			if ($counter==0) :
				$class='active';
			else :
				$class=null;
			endif;

			$html.='<li data-target="#'.$koksijde_slider_config['slider_id'].'" data-slide-to="'.$counter.'" class="'.$class.'"></li>';

		  $counter++;
	  endforeach;
	$html.='</ol>';

	echo apply_filters('koksijde_slider_indicators', $html);
}