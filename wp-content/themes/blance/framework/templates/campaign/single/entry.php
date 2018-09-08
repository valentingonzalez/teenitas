<?php
/**
 * jwsthemes_campaignSingleRender
 *
 */
if( ! function_exists( 'jwsthemes_campaignSingleRender' ) ) :
	function jwsthemes_campaignSingleRender()
	{
		global $post;
		$jwstheme_options = $GLOBALS['jwstheme_options'];
		$thumb_url = ( has_post_thumbnail( $post->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'jwstheme_custom_blog_single_size' )[0] : '';
		$content = get_post_meta( $post->ID, '_campaign_description', true );

		$campaign = new Charitable_Campaign( $post );
		$percent_donated_raw = $campaign->get_percent_donated_raw();
		$time_left = $campaign->get_time_left();
		$donation_summary = $campaign->get_donation_summary();
		$donor_count = $campaign->get_donor_count();

		ob_start();
		?>
		<article id="post-<?php echo esc_attr( $post->ID ); ?>" <?php post_class(); ?>>
			<div class="jwss-campaign-item campaign-temp-default campaign-format-<?php echo esc_attr( basename( __FILE__, '.php' ) ); ?>">
				<div class="campaign-inner">
					<div class="header-meta">
						<?php echo ( ! empty( $thumb_url ) ) ? "<img class='campaign-thumb' src='{$thumb_url}' alt=''>" : '' ?>
						<div class='charitable-meta'>
							<div class='campaign-progress-bar'><span class='bar' style='width: <?php echo esc_attr( $percent_donated_raw ); ?>%;'></span></div>
							<div class='donation-summary'><?php echo "{$donation_summary}"; ?></div>
						</div>
					</div>
					<div class="info-meta">
						<div class="row">
							<div class="col-md-12">
								<div class="extra-meta">
									<div class="post-date">
										<!-- <i class="fa fa-list"></i>  -->
										<?php echo __( 'Created Date: ', 'blance' ) . get_the_date( 'F d, Y', $post->ID ) ?>
									</div><!--
									--><div class="post-author">
										<!-- <i class="fa fa-user"></i>  -->
										<?php echo __( 'Author: ', 'blance' ) . get_the_author() ?>
									</div><!--
									--><div class="post-cate">
										<!-- <i class="fa fa-folder"></i>  -->
									 	<?php echo __( 'Category: ', 'blance' ) . get_the_term_list( $post->ID, 'campaign_category', '', ', ' ); ?>
									</div><!--
									--><div class="post-count-comment">
										<!-- <i class="fa fa-comment"></i>  -->
										<?php echo __( 'Comment(s): ', 'blance' ) . wp_count_comments( $post->ID )->total_comments; ?>
									</div>
								</div>
								<h3 class="title-meta"><?php echo get_the_title( $post->ID ); ?></h3>
							</div>
							<div class="col-md-9 campaign-area-content">
								<div class="content-meta">
									<?php echo "{$content}"; ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="block-meta">
									<div class="block-meta-item b-donate-btn">
										<i class="ion-ios-heart"></i>
										<label><?php _e( 'Donate Online', 'blance' ); ?></label>
										<p>
											<a 
											href='#' 
											class='donate-button charitable-donate-ajax-loadform' 
											data-campaign-id='<?php echo "{$post->ID}" ?>' 
											data-campaign-title='<?php echo get_the_title( $post->ID ); ?>' 
											data-campaign-img='<?php echo "{$thumb_url}" ?>'><?php _e( 'Donate', 'blance' ); ?></a>
										</p>
									</div>
									<div class="block-meta-item b-date-left">
										<i class="ion-ios-calendar"></i>
										<label><?php _e( 'Remaining Time', 'blance' ) ?></label>
										<p><?php echo "{$time_left}"; ?></p>
									</div>
									<div class="block-meta-item b-total-donors">
										<i class="ion-ios-circle-filled"></i>
										<label><?php _e( 'Total Donors', 'blance' ) ?></label>
										<p><?php echo "{$donor_count}"; ?></p>
									</div>
									<div class="block-meta-item b-share">
										<i class="ion-android-share-alt"></i>
										<label><?php _e( 'Share', 'blance' ); ?></label>
										<?php 
										$share_data = json_encode( array(
											'title' => get_the_title( $post->ID ),
											'thumbnail' => $thumb_url,
											'description' => wp_trim_words( $content, 20, '...' )
											) );

										if( function_exists( 'jwss_social_func' ) ) : 
											echo do_shortcode( "[jwss_social social='facebook,twitter,pinterest,google' url='#_EVENTURL' extra_data='{$share_data}']" );
										endif;
										?>
										<p> </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
		<?php
		$output = ob_get_clean();

		return $output;
	}
endif; 

echo jwsthemes_campaignSingleRender();
?>