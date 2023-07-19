<?php

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

function get_header_menu(int $base_indent) {
	return $base_indent;
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
				<?php echo get_header_identity_link(); ?>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggle-menu" aria-controls="toggle-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="toggle-menu">
<?php echo get_header_menu(5); ?>
				</div>
				</button>
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