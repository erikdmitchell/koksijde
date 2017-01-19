/**
 * koksijde_slider_slides function.
 *
 * @access public
 * @return void
 */
function koksijde_slider_slides() {
	global $koksijde_slider_config;

	if (!count($koksijde_slider_config['posts']))
		return false;

	$html=null;
	$counter=0;
	$captions=$koksijde_slider_config['captions'];

	$html.='<div class="carousel-inner">';
		foreach ($koksijde_slider_config['posts'] as $post) :
			if ($counter==0) :
				$class='active';
			else :
				$class=null;
			endif;

			$html.='<div class="item '.$class.'">';
				$html.=koksijde_slider_thumbnail($post->ID);

				if ($captions) :
					$html.='<div class="carousel-caption">';
						$html.='<div class="caption-text">'.apply_filters('the_content', koksijde_slider_get_caption($post)).'</div>';

						if ($koksijde_slider_config['more_button'])
							$html.='<p><a class="btn btn-primary btn-lg" role="button">'.sanitize_text_field($koksijde_slider_config['more_text']).'</a></p>';
					$html.='</div>';
				endif;

			$html.='</div>';

			$counter++;
		endforeach;
	$html.='</div>';

	echo apply_filters('koksijde_slider_slides', $html);
}