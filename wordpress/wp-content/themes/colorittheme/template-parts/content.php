<?php
/**
 * The template part for displaying content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><?php _e( 'Featured', 'colorit' ); ?></span>
		<?php endif; ?>

<div class="card">
	<div class="card-image waves-effect waves-block waves-light">
		<?php colorit_post_thumbnail(); ?>
	</div>
	<div class="card-content">
      <span class="card-title activator grey-text text-darken-4"> <?php the_title( sprintf( '<p class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' ); ?><i class="material-icons right">more_vert</i></span>
      <?php the_title( sprintf( '<p class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' ); ?>
    
    <div class="card-reveal">
      <span class="card-title grey-text text-darken-4"> <?php the_title( sprintf( '<p class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' ); ?><i class="material-icons right">close</i></span>
     <?php
     //excerpt of the posts
			colorit_excerpt();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'colorit' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'colorit' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
    </div>
</div>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
