<?php


/**
 * Custom walker class.
 */
class Thesaas_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		//var_dump( $args->walker->has_children );


		$output .= '<div class="nav-submenu depth-'. $depth .'">' . "\n";
	}


	/**
	 * Ends the list of after the elements are added.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "</div>" . "\n";

		if ( 1 == $depth ) {
			$output .= "</div>" . "\n";
		}
	}


	/**
	 * Start the element output.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		// Build HTML.
		if ( 0 == $depth ) {
			$output .= '<li id="nav-menu-item-'. $item->ID . '" class="nav-item">';
		}
		elseif ( 1 == $depth && $args->walker->has_children ) {
			$output .= '<div class="nav-item">';
		}

		$link_class = "nav-link ". implode( ' ', $item->classes );
		if ( true === $item->current || true === $item->current_item_ancestor ) {
			$link_class .= ' active';
		}
		$link_class = str_replace( 'menu-item ', '', $link_class );

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ' class="'. esc_attr( $link_class ) .'"';


		if ( ! empty( $item->url ) ) :
			$link = $item->url;

			if ( '#' == $link ) {
				$attributes .= ' href="#"';
			}
			elseif ( 0 === strpos( $link, '#' ) ) {
				$attributes .= ' href="#"';
				$attributes .= ' data-scrollto="'. esc_attr( substr( $link, 1 ) ) .'"';
			}
			else {
				$attributes .= ' href="'. esc_url( $link ) .'"';
			}

		endif;

		$arrow = '';
		if ( $args->walker->has_children ) {
			if ( 0 == $depth ) {
				$arrow = ' <i class="fa fa-caret-down"></i>';
			}
			else {
				$arrow = ' <i class="fa fa-caret-right"></i>';
			}

    }

		// Build HTML output and pass through the proper filter.
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%6$s</a>%7$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$arrow,
			$args->after
		);

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}


	/**
	 * Ends the element output, if needed.
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( 0 == $depth ) {
			$output .= "</li>";
		}
		elseif ( 1 == $depth ) {
			//$output .= '</div>';
		}
	}

}
