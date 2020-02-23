<?php
namespace TheThemeio\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class The_Content_Block_1 {

  const ID = 1;

  public function controls( $widget ) {
    $widget->set_id( self::ID );
    $id = self::ID;

    $widget->panel( 'section', [
      'includes' => [ 'bg_gray' ],
      'bg_gray' => true,
    ] );

    $widget->panel( 'header_content', [
      'small'  => esc_html__( 'News', 'thesaas' ),
      'header' => esc_html__( 'Latest Blog Posts', 'thesaas' ),
      'lead'   => esc_html__( 'We are so excited and proud of our theme. It is really easy to create a landing page for your awesome product.', 'thesaas' ),
    ] );


    $widget->panel( 'button', [
      'text' => esc_html__( 'View all', 'thesaas' ),
      'outline' => true,
      'color' => 'btn-primary',
      'link' => thesaas_get_blog_posts_page_url(),
    ] );

  }



  public function html( $widget ) {
    $widget->set_id( self::ID );
    $settings = $widget->get_settings();

    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => 3,
        //'category' => 3,
        'post_status' => 'publish'
    ));

    ?>
    <?php $widget->html('section_tag'); ?>
      <?php $widget->html('section_header'); ?>

        <div class="row gap-y text-center">
          
          <?php foreach( $recent_posts as $post ) : ?>
          <?php
            $post_id = $post['ID'];
            $url = get_permalink( $post_id );
            $content = '';
            if ( has_excerpt( $post_id ) ) {
              $content = get_the_excerpt( $post_id );
            }
            else {
              $extended = get_extended( get_post_field( 'post_content', $post_id ) );
              $content = $extended['main'];
            }

            $categories = wp_get_post_categories( $post_id, [ 'number' => 1 ] );
            $cats = '';
            foreach ( $categories as $cat ) {
              $category = get_category( $cat );
              $cats = sprintf( '<a href="%1$s">%2$s</a>',
                  esc_url( get_category_link( $category->term_id ) ),
                  esc_html( $category->name )
              );
            }
          ?>
            <div class="col-12 col-lg-4">
              <p><a href="<?php echo esc_url( $url ); ?>">
                <?php echo get_the_post_thumbnail( $post_id, 'thesaas-featured-image', [ 'class' => 'shadow-2 rounded' ] ); ?>
              </a></p>
              <h6><a href="<?php echo esc_url( $url ); ?>"><?php echo $post['post_title'] ?></a></h6>
              <p class="small"><?php echo $cats; ?></p>
            </div>
        <?php endforeach; ?>

        </div>

        <br><br>
        <p class="text-center">
          <?php $widget->html('button'); ?>
        </p>

    </div></section>
    <?php
  }



  public function javascript( $widget ) {
    $widget->set_id( self::ID );


    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => 3,
        'post_status' => 'publish'
    ));

    ?>
    <?php $widget->js('section_tag'); ?>
      <?php $widget->js('section_header'); ?>

        <div class="row gap-y text-center">
          
          <?php foreach( $recent_posts as $post ) : ?>
          <?php
            $post_id = $post['ID'];
            $url = get_permalink( $post_id );
            $content = '';
            if ( has_excerpt( $post_id ) ) {
              $content = get_the_excerpt( $post_id );
            }
            else {
              $extended = get_extended( get_post_field( 'post_content', $post_id ) );
              $content = $extended['main'];
            }

            $categories = wp_get_post_categories( $post_id, [ 'number' => 1 ] );
            $cats = '';
            foreach ( $categories as $cat ) {
              $category = get_category( $cat );
              $cats = sprintf( '<a href="%1$s">%2$s</a>',
                  esc_url( get_category_link( $category->term_id ) ),
                  esc_html( $category->name )
              );
            }
          ?>
            <div class="col-12 col-lg-4">
              <p><a href="<?php echo esc_url( $url ); ?>">
                <?php echo get_the_post_thumbnail( $post_id, 'thesaas-featured-image', [ 'class' => 'shadow-2 rounded' ] ); ?>
              </a></p>
              <h6><a href="<?php echo esc_url( $url ); ?>"><?php echo $post['post_title'] ?></a></h6>
              <p class="small"><?php echo $cats; ?></p>
            </div>
        <?php endforeach; ?>

        </div>

        <br><br>
        <p class="text-center">
          <?php $widget->js('button'); ?>
        </p>

    </div></section>
    <?php
  }

}
