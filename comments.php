			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'wip' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title"><?php
			printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'wip' ), number_format_i18n( get_comments_number() ) );
			?></h3>

			<ol class="commentlist">
				<?php wp_list_comments('callback=pro_comments'); ?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'wip' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'wip' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php print  _e( 'Comments are closed.', 'wip' ); ?></p>
	
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<div class="do_com_fix"></div><?php /** fix some layout problem in IE8 */ ?>

<?php 
	
$commenter = wp_get_current_commenter();
$fields =  array(
	'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" placeholder="Name"/></p>',
	'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" placeholder="Email" /></p>',
	'url'    => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Website"/></p>',
);

$newArgs = array(	
	'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'title_reply' => __('Leave a Comment', 'wip'),
	'title_reply_to' => __( 'Leave a Reply to %s', 'wip' ) 
);
comment_form( $newArgs ); 
	
?>
	
</div><!-- #comments -->