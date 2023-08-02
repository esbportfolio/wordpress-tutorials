<?php

declare(strict_types=1);

// Get the site logo if it's present, or the site title if it isn't
function get_title_or_logo_link() {
	// If a custom logo exists:
	if ( has_custom_logo() ) {
		
		// Get the ID for the custom logo
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		// Get the URL for the attachment with that ID
		$logo_url = wp_get_attachment_url($custom_logo_id);
		
		// Show the image
		return '<img src="' . $logo_url . '" class="site-logo">';
		
	// If no custom logo exists:
	} else {
		
		// Show the site title
		return get_bloginfo( 'name' );
		
	}	
}

// Get the site identity link for the page header
function get_header_identity_link() {
	
	// Get the site URL
	$url = get_site_url();
	// Get the item to go in the brand link (either site title or logo)
	$identity = get_title_or_logo_link();
	
	// Return it
	return '<a class="navbar-brand" href="' . $url . '">' . $identity . '</a>';
	
}

// Create a custom navigation walker that will format nav links for Bootstrap 5
class Bootstrap_Nav_Walker extends Walker_Nav_Menu {

}

// Create a class to handle outputting header links
class HeaderLinks {
	
	// Number of tabs to use to indent output
	public int $base_indent;
	// ID for toggler control
	private string $toggler_id;
	
	// Constructor
	function __construct(int $base_indent = 0, string $toggler_id = 'header-nav-toggler') {
		
		// Set the class properties
		$this->base_indent = abs($base_indent);
		$this->toggler_id = $toggler_id;
		
	}
	
	// Make the toggler control button
	private function make_toggler_ctrl() : string {
		
		// Array of attributes to add to the button HTML
		$btn_array = array(
			'class' => 'navbar-toggler',
			'type' => 'button',
			'data-bs-toggle' => 'collapse',
			'data-bs-target' => '#' . $this->toggler_id,
			'aria-controls' => $this->toggler_id,
			'aria-expanded' => 'false',
			'aria-label' => 'Toggle navigation'
		);
		
		// Start the button opening tag
		$btn_start_tag = '<button ';
		// Add each element from the array to the button opening tag
		foreach ($btn_array as $key => $value) {
			$btn_start_tag .= ' ' . $key . '="' . $value . '"';
		}
		// Close the button opening tag with an angle bracket
		$btn_start_tag .= '>';
		
		// Set up the span tag that contains the toggler icon
		$span_tag = '<span class="navbar-toggler-icon"></span>';
		
		// Set the button closing tag
		$btn_end_tag = '</button>';
		
		// Set the output to contain the button opening tag, span tag, and button closing tag
		$output =
			str_repeat("\t", $this->base_indent) . $btn_start_tag . "\n" . 
			str_repeat("\t", $this->base_indent + 1) . $span_tag . "\n" .
			str_repeat("\t", $this->base_indent) . $btn_end_tag . "\n";
		
		// Return the output
		return $output;
		
	}
	
	// Return the header menu as a string
	public function get_header_links() : string {
		
		// Set $output to the results of the wp_nav_menu function
		$output = wp_nav_menu(array(
			// Specify the name of the menu (menu name not location)
			'menu' => 'Tutorial Menu',
			// Set the class for the container div
			'container_class' => 'collapse navbar-collapse',
			// Set the ID for the container div
			'container_id' => $this->toggler_id,
			// Use this fallback to return an empty string if the menu doesn't exist
			'fallback_cb' => function () { return ''; },
			// Don't immediately echo the results
			'echo' => false,
			// Format the ul that contains the navigation items
			'items_wrap' => 
				"\n" .
				str_repeat( "\t", $this->base_indent + 1) . '<ul class="%2$s navbar-nav ms-auto">%3$s' . "\n" . 
				str_repeat( "\t", $this->base_indent + 1 ) . '</ul>' . "\n" . 
				str_repeat( "\t", $this->base_indent ),
			// Invoke a custom walker class
			'walker' => new Bootstrap_Nav_Walker(),
		));
		
		// If the output isn't an empty string (which happens if the menu doesn'tabs
		// exist or is empty), add the toggler control and format
		if ( strlen($output) > 0 ) {
			$output = 
				// Toggler button
				$this->make_toggler_ctrl() . 
				// Indent opening div
				str_repeat( "\t", $this->base_indent ) . 
				// Insert output
				$output . "\n";
		}
		
		// Return the output
		return $output;
		
	}
	
}

?>
<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Begin wp_head -->
<?php wp_head(); ?>
<!-- End wp_head -->
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<?php echo get_header_identity_link() . "\n"; ?>
<!-- Begin getting header links -->
<?php echo (new HeaderLinks(4))->get_header_links(); ?>
<!-- End getting header links -->
			</div>
		</nav>
<!-- Begin wp_nav_menu -->
<?php wp_nav_menu(); ?>
<!-- End wp_nav_menu -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="http://tutorial-wp.test/">Tutorial Page</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item"><a class="nav-link" href="http://tutorial-wp.test/">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="http://tutorial-wp.test/sample-page/">Sample Page</a></li>
						<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="http://tutorial-wp.test/#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Pages</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="https://esbportfolio.com/">My Website</a></li>
							<li><span class="ms-3">GitHub</span>
							<ul class="submenu list-unstyled ms-3">
								<li><a class="dropdown-item" href="https://github.com/esbportfolio/wordpress-tutorials">WordPress Tutorials Repo</a></li>
							</ul>
							</li>
						</ul>
						</li>
						<li class="nav-item"><a class="nav-link" href="https://www.google.com/">Google</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h1>Hello, World</h1>
		<p>This is a placeholder index.php</p>
	</body>
<!-- Begin wp_footer -->
<?php wp_footer(); ?>
<!-- End wp_footer -->
</html>