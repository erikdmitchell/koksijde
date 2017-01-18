<?php
/**
 * The template for displaying the slider
 *
 * @package WordPress
 * @subpackage koksijde
 * @since koksijde 1.0.0
 */
?>

<div id="<?php koksijde_slider_id(); ?>" class="carousel slide koksijde-slider" data-ride="carousel">
	<?php koksijde_slider_indicators(); ?>
	<?php koksijde_slider_slides(); ?>
	<?php koksijde_slider_controls(); ?>
</div>