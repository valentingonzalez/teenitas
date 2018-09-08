<?php
/**
 * jwsthemes_eventSingleRender
 *
 */
if( ! function_exists( 'jwsthemes_eventSingleRender' ) ) :
	function jwsthemes_eventSingleRender()
	{
		global $post;
		$jwstheme_options = $GLOBALS['jwstheme_options'];
		

		ob_start();
		?>
		<article id="post-<?php echo esc_attr( $post->ID ); ?>" <?php post_class(); ?>>
			<div class="jwss-event-item event-temp-default event-format-<?php echo esc_attr( basename( __FILE__, '.php' ) ); ?>">
				<div class="event-inner">
					<div class="info-meta">
						<div class="row">
	
						</div>
					</div>
				</div>
			</div>
		</article>
		<?php
		$output = ob_get_clean();

	}
endif; 

echo jwsthemes_eventSingleRender();
?>
