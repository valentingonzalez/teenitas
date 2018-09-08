<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
	   <?php $comments_number = get_comments_number(); ?>
		<h2 class="comments-title <?php echo esc_attr( $comments_class ); ?>">
				<?php
				if ( $comments_number ) {
					if ( '1' === $comments_number ) {
						/* translators: %s: post title */
						printf( _x( '1 Comment', 'comments title', 'blance' ) );
					} else {
						printf(
						/* translators: 1: number of comments, 2: post title */
							_x(
								'%s Comments',
								'comments title',
								'blance'
							),
							number_format_i18n( $comments_number )
						);
					}
				}
				?>
			</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation col-xs-12 col-sm-12 col-md-12 col-lg-12" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'blance' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'blance' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'blance' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 88,
					'callback' => 'jws_theme_custom_comment',
					'reply_text' => 'Reply <i class="fa fa-long-arrow-right" ></i>',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'blance' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'blance' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'blance' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'blance' ); ?></p>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();
		
		$fields =  array(
			'author' =>
				'<p class="comment-form-author col-lg-4 col-md-4 col-sm-4 col-xs-12"><input id="author" name="author" placeholder = "Name" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',

			'email' =>
				'<p class="comment-form-email col-lg-4 col-md-4 col-sm-4 col-xs-12"><input id="email" name="email" placeholder = "Email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',

			'url' => '<p class="comment-form-url col-lg-4 col-md-4 col-sm-4 col-xs-12"><input id="url" name="url" placeholder = "Website" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) .
				'" size="30" aria-required="true" /></p>',
   	        
  );
		
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'submit ',
			'name_submit'       => 'submit',
			'title_reply'       => __( '<span>Leave a reply</span>', 'blance' ),
			'title_reply_to'    => __( 'Leave a reply %s', 'blance' ),
			'cancel_reply_link' => __( '', 'blance' ),
			'label_submit'      => __( 'post comment', 'blance' ),
			'format'            => 'xhtml',
            
            'comment_field' =>  '<p class="comment-form-comment2 col-lg-12 col-md-12 col-sm-12 col-xs-12"><textarea id="comment" placeholder = "Comment" name="comment" cols="60" rows="6" aria-required="true">' . '</textarea></p>',
		

			'must_log_in' => '<p class="must-log-in">' .
			  sprintf(
				__( 'You must be <a href="%s">logged in</a> to post a comment.', 'blance' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			  ) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
			  sprintf(
			  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'blance' ),
				admin_url( 'profile.php' ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			  ) . '</p>',

			'comment_notes_before' => '',

			'comment_notes_after' => '',

			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		  );

		comment_form($args);
	?>

</div><!-- #comments -->
