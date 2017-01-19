/**
 * koksijde_slider_controls function.
 *
 * @access public
 * @return void
 */
function koksijde_slider_controls() {
	global $koksijde_slider_config;

	if (!count($koksijde_slider_config['posts']) || !$koksijde_slider_config['controls'])
		return false;

	$html=null;

	$html.='<a class="left carousel-control" href="#'.$koksijde_slider_config['slider_id'].'" data-slide="prev">';
		$html.='<span class="glyphicon glyphicon-chevron-left"></span>';
	$html.='</a>';
	$html.='<a class="right carousel-control" href="#'.$koksijde_slider_config['slider_id'].'" data-slide="next">';
		$html.='<span class="glyphicon glyphicon-chevron-right"></span>';
	$html.='</a>';

	echo apply_filters('koksijde_slider_controls', $html);
}