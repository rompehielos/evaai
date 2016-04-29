<?php

final class AI_Theme /*implements ArrayAccess*/ {
	
	private $stylesheet;
	
	private static $persistently_cache;
	
	/**
	 * Constructor for AI_Theme.
	 *
	 * @global array $wp_theme_directories
	 *
	 * @param string $theme_dir Directory of the theme within the theme_root.
	 * @param string $theme_root Theme root.
	 * @param AI_Error|void $_child If this theme is a parent theme, the child may be passed for validation purposes.
	 */
	public function __construct( $theme_dir, $theme_root, $_child = null ) {
		global $wp_theme_directories;

		// Initialize caching on first run.
		if ( ! isset( self::$persistently_cache ) ) {
			/** This action is documented in wp-includes/theme.php */
			self::$persistently_cache = apply_filters( 'ai_cache_themes_persistently', false, 'AI_Theme' );
			if ( self::$persistently_cache ) {
				wp_cache_add_global_groups( 'themes' );
				if ( is_int( self::$persistently_cache ) )
					self::$cache_expiration = self::$persistently_cache;
			} else {
				wp_cache_add_non_persistent_groups( 'themes' );
			}
		}

		$this->theme_root = $theme_root;
		$this->stylesheet = $theme_dir;

		// Correct a situation where the theme is 'some-directory/some-theme' but 'some-directory' was passed in as part of the theme root instead.
		if ( ! in_array( $theme_root, (array) $wp_theme_directories ) && in_array( dirname( $theme_root ), (array) $wp_theme_directories ) ) {
			$this->stylesheet = basename( $this->theme_root ) . '/' . $this->stylesheet;
			$this->theme_root = dirname( $theme_root );
		}

		$this->cache_hash = md5( $this->theme_root . '/' . $this->stylesheet );
		$theme_file = $this->stylesheet . '/style.css';

		$cache = $this->cache_get( 'theme' );

		if ( is_array( $cache ) ) {
			foreach ( array( 'errors', 'headers', 'template' ) as $key ) {
				if ( isset( $cache[ $key ] ) )
					$this->$key = $cache[ $key ];
			}
			if ( $this->errors )
				return;
			if ( isset( $cache['theme_root_template'] ) )
				$theme_root_template = $cache['theme_root_template'];
		} elseif ( ! file_exists( $this->theme_root . '/' . $theme_file ) ) {
			$this->headers['Name'] = $this->stylesheet;
			if ( ! file_exists( $this->theme_root . '/' . $this->stylesheet ) )
				$this->errors = new AI_Error( 'theme_not_found', sprintf( __( 'The theme directory "%s" does not exist.' ), esc_html( $this->stylesheet ) ) );
			else
				$this->errors = new AI_Error( 'theme_no_stylesheet', __( 'Stylesheet is missing.' ) );
			$this->template = $this->stylesheet;
			$this->cache_add( 'theme', array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template ) );
			if ( ! file_exists( $this->theme_root ) ) // Don't cache this one.
				$this->errors->add( 'theme_root_missing', __( 'ERROR: The themes directory is either empty or doesn&#8217;t exist. Please check your installation.' ) );
			return;
		} elseif ( ! is_readable( $this->theme_root . '/' . $theme_file ) ) {
			$this->headers['Name'] = $this->stylesheet;
			$this->errors = new AI_Error( 'theme_stylesheet_not_readable', __( 'Stylesheet is not readable.' ) );
			$this->template = $this->stylesheet;
			$this->cache_add( 'theme', array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template ) );
			return;
		} else {
			$this->headers = get_file_data( $this->theme_root . '/' . $theme_file, self::$file_headers, 'theme' );
			// Default themes always trump their pretenders.
			// Properly identify default themes that are inside a directory within wp-content/themes.
			if ( $default_theme_slug = array_search( $this->headers['Name'], self::$default_themes ) ) {
				if ( basename( $this->stylesheet ) != $default_theme_slug )
					$this->headers['Name'] .= '/' . $this->stylesheet;
			}
		}

		// (If template is set from cache [and there are no errors], we know it's good.)
		if ( ! $this->template && ! ( $this->template = $this->headers['Template'] ) ) {
			$this->template = $this->stylesheet;
			if ( ! file_exists( $this->theme_root . '/' . $this->stylesheet . '/index.php' ) ) {
				$error_message = sprintf(
					/* translators: 1: index.php, 2: Codex URL, 3: style.css */
					__( 'Template is missing. Standalone themes need to have a %1$s template file. <a href="%2$s">Child themes</a> need to have a Template header in the %3$s stylesheet.' ),
					'<code>index.php</code>',
					__( 'https://codex.wordpress.org/Child_Themes' ),
					'<code>style.css</code>'
				);
				$this->errors = new AI_Error( 'theme_no_index', $error_message );
				$this->cache_add( 'theme', array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template ) );
				return;
			}
		}

		// If we got our data from cache, we can assume that 'template' is pointing to the right place.
		if ( ! is_array( $cache ) && $this->template != $this->stylesheet && ! file_exists( $this->theme_root . '/' . $this->template . '/index.php' ) ) {
			// If we're in a directory of themes inside /themes, look for the parent nearby.
			// wp-content/themes/directory-of-themes/*
			$parent_dir = dirname( $this->stylesheet );
			if ( '.' != $parent_dir && file_exists( $this->theme_root . '/' . $parent_dir . '/' . $this->template . '/index.php' ) ) {
				$this->template = $parent_dir . '/' . $this->template;
			} elseif ( ( $directories = search_theme_directories() ) && isset( $directories[ $this->template ] ) ) {
				// Look for the template in the search_theme_directories() results, in case it is in another theme root.
				// We don't look into directories of themes, just the theme root.
				$theme_root_template = $directories[ $this->template ]['theme_root'];
			} else {
				// Parent theme is missing.
				$this->errors = new AI_Error( 'theme_no_parent', sprintf( __( 'The parent theme is missing. Please install the "%s" parent theme.' ), esc_html( $this->template ) ) );
				$this->cache_add( 'theme', array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template ) );
				$this->parent = new AI_Theme( $this->template, $this->theme_root, $this );
				return;
			}
		}

		// Set the parent, if we're a child theme.
		if ( $this->template != $this->stylesheet ) {
			// If we are a parent, then there is a problem. Only two generations allowed! Cancel things out.
			if ( $_child instanceof AI_Theme && $_child->template == $this->stylesheet ) {
				$_child->parent = null;
				$_child->errors = new AI_Error( 'theme_parent_invalid', sprintf( __( 'The "%s" theme is not a valid parent theme.' ), esc_html( $_child->template ) ) );
				$_child->cache_add( 'theme', array( 'headers' => $_child->headers, 'errors' => $_child->errors, 'stylesheet' => $_child->stylesheet, 'template' => $_child->template ) );
				// The two themes actually reference each other with the Template header.
				if ( $_child->stylesheet == $this->template ) {
					$this->errors = new AI_Error( 'theme_parent_invalid', sprintf( __( 'The "%s" theme is not a valid parent theme.' ), esc_html( $this->template ) ) );
					$this->cache_add( 'theme', array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template ) );
				}
				return;
			}
			// Set the parent. Pass the current instance so we can do the crazy checks above and assess errors.
			$this->parent = new AI_Theme( $this->template, isset( $theme_root_template ) ? $theme_root_template : $this->theme_root, $this );
		}

		// We're good. If we didn't retrieve from cache, set it.
		if ( ! is_array( $cache ) ) {
			$cache = array( 'headers' => $this->headers, 'errors' => $this->errors, 'stylesheet' => $this->stylesheet, 'template' => $this->template );
			// If the parent theme is in another root, we'll want to cache this. Avoids an entire branch of filesystem calls above.
			if ( isset( $theme_root_template ) )
				$cache['theme_root_template'] = $theme_root_template;
			$this->cache_add( 'theme', $cache );
		}
	}
	
	public function get_stylesheet() {
		return $this->stylesheet;
	}
}