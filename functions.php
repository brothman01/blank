<?php // @codingStandardsIgnoreLine
/*
Author: Ben Rothman
URL: https://www.BenRothman.org

This theme is a blank theme with common building blocks like bootstrap, fontawesome and fitvid.js that can be used by web developers.  (parts from Bones by Eddie Macado and Brew by Dan Brown are used to make this theme too)
*/

/************* INCLUDE NEEDED FILES ***************/

class Functions { // @codingStandardsIgnoreLine

	public function __construct() {
		require_once( 'library/navwalker.php' ); // needed for bootstrap navigation

		// REDUX.  Needed for custom admin panel
		// https://github.com/ReduxFramework/ReduxFramework

		if ( ! class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/library/admin/ReduxCore/framework.php' ) ) {
			require_once( dirname( __FILE__ ) . '/library/admin/ReduxCore/framework.php' );
		}

		if ( ! isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/library/option-config.php' ) ) {
			require_once( dirname( __FILE__ ) . '/library/option-config.php' );
		}

		// Retrieve the $brew_option values to make them available in this file
		global $brew_options;

		// Show/Hide brew menu on the dashboard
		if ( 1 == $brew_options['brewmenu'] ) {
			add_action( 'admin_menu', [ $this, 'dashboard_brew_menu_removal' ] );
		}

		// Open Brew Menus on hover instead of on click
		if ( 1 == $brew_options['open_menus_on_hover'] ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'hovermenu_enqueue' ] );
		}

		// Custom metaboxes and fields
		// https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
		add_action( 'init', [ $this, 'be_initialize_cmb_meta_boxes' ], 9999 );

		// enqueue FontAwesome5
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_fontawesome' ] );

		/* library/bones.php (functions specific to BREW)
		- navwalker
		- Redux framework
		- Read more > Bootstrap button
		- Bootstrap style pagination
		- Bootstrap style breadcrumbs
		*/
		require_once( 'library/brew.php' ); // if you remove this, BREW will break
		/*
		1. library/bones.php
			- head cleanup (remove rsd, uri links, junk css, ect)
			- enqueueing scripts & styles
			- theme support functions
			- custom menu output & fallbacks
			- related post function
			- page-navi function
			- removing <p> from around images
			- customizing the post excerpt
			- custom google+ integration
			- adding custom fields to user profiles
		*/
		require_once( 'library/bones.php' ); // if you remove this, bones will break

		/*
		3. library/admin.php
			- removes some default WordPress dashboard widgets
			- shows an example custom dashboard widget
			- adds custom login css
			- changes text in footer of admin
		*/
		require_once( 'library/admin.php' ); // this comes turned off by default
		/*


		/************* THUMBNAIL SIZE OPTIONS *************/

		// Thumbnail sizes
		add_image_size( 'bones-thumb-600', 600, 150, true );
		add_image_size( 'bones-thumb-300', 300, 100, true );
		add_image_size( 'post-featured', 750, 300, true );
		/*
		to add more sizes, simply copy a line from above
		and change the dimensions & name. As long as you
		upload a "featured image" as large as the biggest
		set width or height, all the other sizes will be
		auto-cropped.

		To call a different size, simply change the text
		inside the thumbnail function.

		For example, to call the 300 x 300 sized image,
		we would use the function:
		<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
		for the 600 x 100 image:
		<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

		You can change the names and dimensions to whatever
		you like. Enjoy!
		*/

		add_action( 'widgets_init', [ $this, 'bones_register_sidebars' ] );

	}



	public function be_initialize_cmb_meta_boxes() {
		if ( ! class_exists( 'cmb_Meta_Box' ) ) {
			require_once( 'library/metabox/init.php' );
		}
	}

	public function dashboard_brew_menu_removal() {
		remove_menu_page( '_options' );
	}

	public function hovermenu_enqueue() {
		wp_enqueue_style( 'hovermenus', get_template_directory_uri() . '/library/css/hovermenus.css', false, '1.0', 'all' );
	}

	public function enqueue_fontawesome() {
		wp_enqueue_script( 'fontawesome5', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js' );
	}


		/*************** SIDEBAR LAYOUT **************/
	public function sb_register_sidebars() {}

	// Sidebars & Widgetizes Areas
	public function bones_register_sidebars() {
		register_sidebar(array(
			'id'            => 'sidebar1',
			'name'          => __( 'Sidebar 1', 'bonestheme' ),
			'description'   => __( 'The first (primary) sidebar.', 'bonestheme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		));

		// add footer widgets
		register_sidebar(array(
			'id'            => 'footer-1',
			'name'          => __( 'Footer Widget 1', 'bonestheme' ),
			'description'   => __( 'The first footer widget.', 'bonestheme' ),
			'before_widget' => '<div id="%1$s" class="widget widgetFooter %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		));

		register_sidebar(array(
			'id'            => 'footer-2',
			'name'          => __( 'Footer Widget 2', 'bonestheme' ),
			'description'   => __( 'The second footer widget.', 'bonestheme' ),
			'before_widget' => '<div id="%1$s" class="widget widgetFooter %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		));

		register_sidebar(array(
			'id'            => 'footer-3',
			'name'          => __( 'Footer Widget 3', 'bonestheme' ),
			'description'   => __( 'The third footer widget.', 'bonestheme' ),
			'before_widget' => '<div id="%1$s" class="widget widgetFooter %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		));

		register_sidebar(array(
			'id'            => 'footer-4',
			'name'          => __( 'Footer Widget 4', 'bonestheme' ),
			'description'   => __( 'The fourth footer widget.', 'bonestheme' ),
			'before_widget' => '<div id="%1$s" class="widget widgetFooter %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		));

			/*
			to add more sidebars or widgetized areas, just copy
			and edit the above sidebar code. In order to call
			your new sidebar just use the following code:

			Just change the name to whatever your new
			sidebar's id is, for example:

			register_sidebar(array(
				'id' => 'sidebar2',
				'name' => __( 'Sidebar 2', 'bonestheme' ),
				'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widgettitle">',
				'after_title' => '</h4>',
			));

		To call the sidebar in your template, you can just copy
		the sidebar.php file and rename it to your sidebar's name.
		So using the above example, it would be:
		sidebar-sidebar2.php

		*/
	}

	/*************** PINGS LAYOUT **************/
	public function sb_list_pings( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>">
		<span class="pingcontent">
			<cite class="fn"><?php echo get_comment_author_link(); ?></cite> <span class="says"></span>
			<?php comment_text(); ?>
		</span>
	</li>
<?php
	} // end list_pings
}

$themeobject = new functions();
