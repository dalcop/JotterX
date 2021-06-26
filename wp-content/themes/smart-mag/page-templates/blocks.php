<?php
/**
 * Template Name: Pagebuilder
 * 
 * Same as page.php but with different wrapper/content classes.
 */
Bunyad::core()->partial('page', [
	'content_class' => 'page-content',
	'breadcrumbs'   => false
]);