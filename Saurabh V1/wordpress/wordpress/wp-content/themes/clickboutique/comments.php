<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to pt_comments() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

  <h3 class="pt-content-title comments-title"><?php printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'plumtree' ), number_format_i18n( get_comments_number() ) ); ?></h3>
	
	<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'pt_comments', 'style' => 'ol' ) ); ?>
	</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
  		<?php $comments_pagination = get_option('comments_pagination');
        if ($comments_pagination == 'numeric') : ?>
          <nav class="navigation comment-numeric-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'plumtree' ); ?></h1>
            <?php paginate_comments_links( array(
              'prev_text' => __('Prev', 'plumtree'), 
              'next_text' => __('Next', 'plumtree'),
              'type'      => 'plain',
              )); ?>  			
       		</nav>
        <?php else : ?>
          <nav class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'plumtree' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'plumtree' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'plumtree' ) ); ?></div>
          </nav>
        <?php endif; ?>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
  		<p class="comments-closed"><?php _e( 'Comments are closed.' , 'plumtree' ); ?></p>
		<?php endif; ?>

	<?php else : ?>

	<p class="nocomments"><?php _e( 'No comments yet.' , 'plumtree' ); ?></p>

	<?php endif; // have_comments() ?>

</div><!-- #comments .comments-area -->

<?php // Custom Comment form

$new_args = array(
  'title_reply'       => __( 'Leave a Comment', 'plumtree' ),
  'cancel_reply_link' => __( 'Cancel Reply', 'plumtree' ),
  'label_submit'      => __( 'Submit', 'plumtree' ),

  'comment_field'     =>
    '<p class="comment-form-comment">
      <label for="comment">' .__( 'Comment ...', 'plumtree' ) . '</label>
      <textarea id="comment" name="comment" type="text" aria-required="true" placeholder="' . __( 'Comment ...', 'plumtree' ) . '"></textarea>
    </p>',

  'must_log_in'       => 
    '<p class="must-log-in">' .
      sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'plumtree' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) 
    . '</p>',

  'logged_in_as'      => 
    '<p class="logged-in-as">' .
    sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'plumtree' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) 
    . '</p>',

  'comment_notes_before' => false,

  'comment_notes_after'  => false,

  'fields'            => 
    apply_filters( 'comment_form_default_fields', array(
      'author' =>
        '<p class="comment-form-author">
          <label for="author">'. __( 'Name', 'plumtree' ) . ( $req ? '<span class="required">'.__( '(required)', 'plumtree' ).'</span>' : '' ) . '</label>
          <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" placeholder="' . __( 'Name', 'plumtree' ) . ( $req ? __( ' (required)', 'plumtree' ) : '' ) . '" />
        </p>',

      'email' =>
        '<p class="comment-form-email">
          <label for="email">'. __( 'E-mail', 'plumtree' ) . ( $req ? '<span class="required">'.__( '(required)', 'plumtree' ).'</span>' : '' ) . '</label>
          <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-required="true" placeholder="' . __( 'E-mail', 'plumtree' ) . ( $req ? __( ' (required)', 'plumtree' ) : '' ) . '" />
        </p>',

      'url' =>
        '<p class="comment-form-url">
          <label for="url">'. __( 'Website', 'plumtree' ) . '</label>
          <input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website', 'plumtree' ) . '" />
        </p>',
      )
    ),
); ?>

<?php comment_form( $new_args ); ?>
