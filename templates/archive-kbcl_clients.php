<?php
/**
 * The template for displaying the Testimonials Archive page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
get_header();
?>

<div class="kcontainer" style="overflow: hidden;">

    <div class="kclients">
        
            <?php if ( kbcl_get_page_title() ) { ?>
                <h2 class="page-title">
                    <?php echo kbcl_get_page_title(); ?>
                </h2>
            <?php } ?>

            <div class="kcontentbefore">
                <?php echo wpautop( kbcl_get_page_content_before() ); ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="kclients">
                    
                    <ul class="small-kebo-grid-4 medium-kebo-grid-6 large-kebo-grid-8">

                        <?php while ( have_posts() ) : the_post(); ?>
                        
                            <li>

                                <div id="post-<?php the_ID(); ?>" <?php post_class( 'kclient' ); ?>>

                                    <div class="klogo" title="<?php the_title(); ?>">
                                        <?php
                                        if ( has_post_thumbnail() ) {
                                            
                                            the_post_thumbnail( 'thumbnail' );
                                            
                                        } else {
                                            
                                            the_title();
                                            
                                        }
                                        ?>
                                    </div>

                                </div><!-- #post-<?php the_ID(); ?> -->

                            </li>

                        <?php endwhile; ?>
                        
                    </ul>
                        
                </div><!-- .kclients -->
                
                <?php kbcl_pagination_nav(); ?>

            <?php else : ?>
                        
                <?php
                global $wp_post_types;
                $cpt = $wp_post_types['kbcl_clients'];
                ?>
                <?php if ( current_user_can( 'publish_posts' ) ) : ?>

                    <p><?php printf( __('Ready to create your first %2$s? <a href="%1$s">Get started here</a>.', 'kbcl'), admin_url( 'post-new.php?post_type=kbcl_clients' ), $cpt->labels->singular_name ); ?></p>

                <?php else : ?>

                    <p><?php printf( __('Sorry, there are currently no %1$s to display.', 'kbcl'), $cpt->labels->name ); ?></p>

                <?php endif; ?>

            <?php endif; ?>

    </div><!-- .kcontainer -->
    
</div><!-- .ktestimonials -->

<?php get_footer(); ?>