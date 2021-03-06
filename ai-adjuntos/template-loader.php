<?php
/**
 * Carga la plantilla correcta según la URL del visitante
 */
if ( defined('AI_USE_THEMES') && AI_USE_THEMES ) {
	/**
	 * Fires before determining which template to load.
	 *
	 */
	#do_action( 'template_redirect' );
}

if ( 'HEAD' === $_SERVER['REQUEST_METHOD'] && apply_filters( 'exit_on_http_head', true ) ) {
	exit();
}


/** Muestra la plantilla de acuerdo a la página visitada. */
/*if ( defined('AI_USE_THEMES') && AI_USE_THEMES ) {
	$template = false;
	if     ( is_embed()          && $template = get_embed_template()          ) :
	elseif ( is_404()            && $template = get_404_template()            ) :
	elseif ( is_search()         && $template = get_search_template()         ) :
	elseif ( is_front_page()     && $template = get_front_page_template()     ) :
	elseif ( is_home()           && $template = get_home_template()           ) :
	elseif ( is_post_type_archive() && $template = get_post_type_archive_template() ) :
	elseif ( is_tax()            && $template = get_taxonomy_template()       ) :
	elseif ( is_attachment()     && $template = get_attachment_template()     ) :
		remove_filter('the_content', 'prepend_attachment');
	elseif ( is_single()         && $template = get_single_template()         ) :
	elseif ( is_page()           && $template = get_page_template()           ) :
	elseif ( is_singular()       && $template = get_singular_template()       ) :
	elseif ( is_category()       && $template = get_category_template()       ) :
	elseif ( is_tag()            && $template = get_tag_template()            ) :
	elseif ( is_author()         && $template = get_author_template()         ) :
	elseif ( is_date()           && $template = get_date_template()           ) :
	elseif ( is_archive()        && $template = get_archive_template()        ) :
	elseif ( is_paged()          && $template = get_paged_template()          ) :
	else :
		$template = get_index_template();
	endif;
	/**
	 * Filter the path of the current template before including it.
	 *
	 * @param string $template The path of the template to include.
	 */
	/*if ( $template = apply_filters( 'template_include', $template ) ) {
		include( $template );
	} elseif ( current_user_can( 'switch_themes' ) ) {
		$theme = ai|_get_theme();
		if ( $theme->errors() ) {
			ai_die( $theme->errors() );
		}
	}
	return;
}*/

require './ai-contenido/themes/prueba/index.php';
