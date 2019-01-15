<?php
/**
 * The main template file
 */
;?>
<?php get_header();?>


	<?php if ( have_posts() ) : ?>
		<header>
		<h4 class="brown-text center templates"><?php single_post_title(); ?></h4>
	</header>
	<div class="row">
	<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				?>
				
				<div class="col l6 m6 s12"> 
					<?php 
				get_template_part( 'template-parts/content', get_post_format() ); ?>
				</div>
			
			<?php

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( '<a class="materialize-icon>arrow_back</a>"', 'colorit' ),
				'next_text'          => __( '<a class="materialize-icon>arrow_back</a>"', 'colorit' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'colorit' ) . ' </span>',
			) );
			// End the loop.
			endwhile;

			

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
</div>
	</div>
</div>



<?php get_footer();?>