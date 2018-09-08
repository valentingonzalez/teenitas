<?php 
/*
Plugin Name: JWS Post Type
Description: Register post types needed for JWS themes
Version: 1.0
Text Domain: jwstheme_post_type
*/
class blance_Post_Types {

	public $domain = 'blance_starter';

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blance' ), '2.1' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blance' ), '2.1' );
	}

	public function __construct() {
		
		// Hook into the 'init' action
		add_action( 'init', array($this, 'register_blocks'), 1 );

		// Add shortcode column to block list
		add_filter( 'manage_edit-visual_content_columns', array($this, 'edit_heading_columns') ) ;
		add_action( 'manage_visual_content_posts_custom_column', array($this, 'create_shortcode_vc'), 10, 2 );

		add_filter( 'manage_edit-portfolio_columns', array($this, 'edit_portfolio_columns') ) ;
		add_action( 'manage_portfolio_posts_custom_column', array($this, 'manage_portfolio_columns'), 10, 2 );

		add_action( 'init', array($this, 'register_portfolio'), 1 );

	}
	public function register_blocks() {

		$labels = array(
			'name'                => _x( 'Visul Composer Content', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'Visul Composer Content', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'Visul Composer Content', $this->domain ),
			'parent_item_colon'   => __( 'Parent Item:', $this->domain ),
			'all_items'           => __( 'All Items', $this->domain ),
			'view_item'           => __( 'View Item', $this->domain ),
			'add_new_item'        => __( 'Add New Item', $this->domain ),
			'add_new'             => __( 'Add New', $this->domain ),
			'edit_item'           => __( 'Edit Item', $this->domain ),
			'update_item'         => __( 'Update Item', $this->domain ),
			'search_items'        => __( 'Search Item', $this->domain ),
			'not_found'           => __( 'Not found', $this->domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->domain ),
		);

		$args = array(
			'label'               => __( 'visual_content', $this->domain ),
			'description'         => __( 'Visual content for custom HTML to place in your pages', $this->domain ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-schedule',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'visual_content', $args );

	}


	public function edit_heading_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', $this->domain ),
			'shortcode' => __( 'Shortcode', $this->domain ),	   
			'date' => __( 'Date', $this->domain ),
		);

		return $columns;
	}


	public function create_shortcode_vc($column, $post_id) {
		switch( $column ) {
			case 'shortcode' :
				echo '<strong>[vc_content id="'.$post_id.'"]</strong>';
			break;
		}	
	}
		// **********************************************************************// 
	// ! Register Custom Post Type for portfolio
	// **********************************************************************// 
	public function register_portfolio() {

		$labels = array(
			'name'                => _x( 'Portfolio', 'Post Type General Name', $this->domain ),
			'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', $this->domain ),
			'menu_name'           => __( 'Portfolio', $this->domain ),
			'parent_item_colon'   => __( 'Parent Item:', $this->domain ),
			'all_items'           => __( 'All Items', $this->domain ),
			'view_item'           => __( 'View Item', $this->domain ),
			'add_new_item'        => __( 'Add New Item', $this->domain ),
			'add_new'             => __( 'Add New', $this->domain ),
			'edit_item'           => __( 'Edit Item', $this->domain ),
			'update_item'         => __( 'Update Item', $this->domain ),
			'search_items'        => __( 'Search Item', $this->domain ),
			'not_found'           => __( 'Not found', $this->domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->domain ),
		);

		$args = array(
			'label'               => __( 'portfolio', $this->domain ),
		      'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
            'taxonomies'          => array( 'portfolio_cat' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-yes',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
		);

		register_post_type( 'portfolio', $args );

		/**
		 * Create a taxonomy category for portfolio
		 *
		 * @uses  Inserts new taxonomy object into the list
		 * @uses  Adds query vars
		 *
		 * @param string  Name of taxonomy object
		 * @param array|string  Name of the object type for the taxonomy object.
		 * @param array|string  Taxonomy arguments
		 * @return null|WP_Error WP_Error if errors, otherwise null.
		 */
		
		$labels = array(
			'name'					=> _x( 'Portfolio Categories', 'Taxonomy plural name', $this->domain ),
			'singular_name'			=> _x( 'Portfolio Category', 'Taxonomy singular name', $this->domain ),
			'search_items'			=> __( 'Search Categories', $this->domain ),
			'popular_items'			=> __( 'Popular Portfolio Categories', $this->domain ),
			'all_items'				=> __( 'All Portfolio Categories', $this->domain ),
			'parent_item'			=> __( 'Parent Category', $this->domain ),
			'parent_item_colon'		=> __( 'Parent Category', $this->domain ),
			'edit_item'				=> __( 'Edit Category', $this->domain ),
			'update_item'			=> __( 'Update Category', $this->domain ),
			'add_new_item'			=> __( 'Add New Category', $this->domain ),
			'new_item_name'			=> __( 'New Category', $this->domain ),
			'add_or_remove_items'	=> __( 'Add or remove Categories', $this->domain ),
			'choose_from_most_used'	=> __( 'Choose from most used text-domain', $this->domain ),
			'menu_name'				=> __( 'Category', $this->domain ),
		);
	
		$args = array(
			'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'portfolio_cat' ),
		);
		register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $args );

	}
	public function edit_portfolio_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'thumb' => '',
			'title' => __( 'Title', $this->domain ),
			'portfolio_cat' => __( 'Categories', $this->domain ),	   
			'date' => __( 'Date', $this->domain ),
		);

		return $columns;
	}
	public function manage_portfolio_columns($column, $post_id) {
		switch( $column ) {
			case 'thumb' :
				if( has_post_thumbnail( $post_id ) ) {
					the_post_thumbnail( array(60,60) );
				}
			break;
			case 'portfolio_cat' :
				$terms = get_the_terms( $post_id, 'portfolio_cat' );
										
				if ( $terms && ! is_wp_error( $terms ) ) : 

					$cats_links = array();

					foreach ( $terms as $term ) {
						$cats_links[] = $term->name;
					}
										
					$cats = join( ", ", $cats_links );
				?>

				<span><?php echo $cats; ?></span>

				<?php endif; 
			break;
		}	
	}
	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
}

function blance_Theme_Plugin() {
	return blance_Post_Types::instance();
}

$GLOBALS['blance_theme_plugin'] = blance_Theme_Plugin();

?>