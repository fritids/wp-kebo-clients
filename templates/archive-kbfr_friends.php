<?php
/**
 * The template for displaying the Testimonials Archive page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
get_header();
?>

<div class="kcontainer" style="overflow: hidden;">

    <div class="kfriends">
        
            <?php if ( kbfr_get_page_title() ) { ?>
                <h2 class="page-title">
                    <?php echo kbfr_get_page_title(); ?>
                </h2>
            <?php } ?>

            <div class="kcontentbefore">
                <?php echo wpautop( kbfr_get_page_content_before() ); ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="kfriends">
                    
                    <ul class="small-kebo-grid-4 medium-kebo-grid-6 large-kebo-grid-8">

                        <?php while ( have_posts() ) : the_post(); ?>
                        
                            <?php
                            $kbfr_custom_meta = get_post_meta( get_the_ID(), '_kbfr_friends_meta_details', true );
                            // Defaults if not set
                            $url = ( isset( $kbfr_custom_meta['friend_url'] ) ) ? $kbfr_custom_meta['friend_url'] : '' ;
                            ?>
                        
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
                                        <div>URL: <?php echo $url; ?></div>
                                    </div>

                                </div><!-- #post-<?php the_ID(); ?> -->

                            </li>

                        <?php endwhile; ?>
                        
                    </ul>
                        
                </div><!-- .kfriends -->
                
                <?php kbfr_pagination_nav(); ?>

            <?php else : ?>
                        
                <?php
                global $wp_post_types;
                $cpt = $wp_post_types['kbfr_friends'];
                ?>
                <?php if ( current_user_can( 'publish_posts' ) ) : ?>

                    <p><?php printf( __('Ready to create your first %2$s? <a href="%1$s">Get started here</a>.', 'kbfr'), admin_url( 'post-new.php?post_type=kbfr_friends' ), $cpt->labels->singular_name ); ?></p>

                <?php else : ?>

                    <p><?php printf( __('Sorry, there are currently no %1$s to display.', 'kbfr'), $cpt->labels->name ); ?></p>

                <?php endif; ?>

            <?php endif; ?>

    </div><!-- .kcontainer -->
    
</div><!-- .kfriends -->

<?php get_footer(); ?>