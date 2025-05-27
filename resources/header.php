<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$templatesManager = get_container()->get(\OnePix\WordPressComponents\TemplatesManager::class);
$templatesManager->printTemplate('alert', [
    'message' => 'This is alert',
]);
?>
<h1>Home page</h1>