<?php
/**
 * The template for displaying the footer
 */

?>

</div>
<div class="clear"></div>
  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">

          
        <?php get_sidebar(); ?>


        </div>
<div class="col l6 s12">
<?php get_sidebar( 'content-bottom' ); ?>
      </div>
    </div>
  </div>
 <div class=" teal darken-1">
   

<div class="fixed-action-btn">
  <a class="btn-floating btn-large red">
    <i class="large material-icons">filter_tilt_shift</i>
  </a>
  <ul>
    <li><a href="#up" class="btn-floating red"><i class="material-icons">arrow_upward</i></a></li>
    <li><a href="#down" class="btn-floating yellow darken-1"><i class="material-icons">arrow_downward</i></a></li>
  </ul>
</div>
        

  <div class="nav-footer nav-wrapper center teal darken-1">
      
   

      
 
  <!-- Social media menu -->
  <div class="footer-social-icons">
    
    <ul class="social-icons">
        <li><a href="<?php echo get_theme_mod('menulinks_facebook', '#');?>" class="social-icon"> <i class="fa fa-facebook"></i></a></li>
        <li><a href="<?php echo get_theme_mod('menulinks_twitter', '#');?>" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
        <li><a href="<?php echo get_theme_mod('menulinks_rss', '#');?>" class="social-icon"> <i class="fa fa-rss"></i></a></li>
        <li><a href="<?php echo get_theme_mod('menulinks_youtube', '#');?>" class="social-icon"> <i class="fa fa-youtube"></i></a></li>
        <li><a href="<?php echo get_theme_mod('menulinks_linkedin', '#');?>" class="social-icon"> <i class="fa fa-linkedin"></i></a></li>
        <li><a href="<?php echo get_theme_mod('menulinks_google+', '#');?>" class="social-icon"> <i class="fa fa-google-plus"></i></a></li>
    </ul>
</div>
 <a href="<?php echo get_theme_mod('copy_link', 'coloredit.org');?>" class="brown-text text-lighten-3 center"><?php echo get_theme_mod('copy', 'copyright info') ;?></a>
</div>
      
      
</div>
    <div id="down"></div>
  </footer>
 </body>
 </html>


<?php wp_footer(); ?>