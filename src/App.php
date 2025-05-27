<?php

declare(strict_types=1);

namespace OnePix\WordPress;

use OnePix\WordPressContracts\ActionsRegistrar;

use function add_image_size;
use function add_menu_page;
use function esc_html;
use function get_admin_page_title;
use function load_plugin_textdomain;
use function plugin_basename;
use function register_nav_menus;
use function register_post_type;
use function register_taxonomy;

final class App
{
    public function __construct(
        private readonly ActionsRegistrar $actionsRegistrar,
    ) {
    }

    public function run(): void
    {
        $this->actionsRegistrar->add('init', function (): void {
            di()->call($this->init(...));
        });

        $this->actionsRegistrar->add('admin_menu', function (): void {
            di()->call($this->adminMenu(...));
        });
    }

    private function init(): void
    {
  
        $this->registerPostTypes();
        $this->registerTaxonomies();
        
        $config = di()->get('config');

        $langPath = $config->get('app.translationsPath');

        load_theme_textdomain('br-one', false, $langPath);

        add_image_size('onepix-featured', 1200, 600, true);
        add_image_size('onepix-thumbnail', 300, 300, true);
        
        register_nav_menus([
            'primary' => __('Primary Menu', 'br-one'),
            'footer' => __('Footer Menu', 'br-one'),
        ]);
    }

    private function adminMenu(): void
    {

        add_menu_page(
            __('OnePix Settings', 'br-one'),
            __('OnePix', 'br-one'),
            'manage_options',
            'onepix-settings',
            [$this, 'renderSettingsPage'],
            'dashicons-admin-generic',
            30
        );
    }

    private function registerPostTypes(): void
    {
        register_post_type('br_one_portfolio', [
            'labels' => [
                'name' => __('Portfolio', 'br-one'),
                'singular_name' => __('Portfolio Item', 'br-one'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => ['slug' => 'portfolio'],
        ]);
    }

    private function registerTaxonomies(): void
    {
        register_taxonomy('onepix_portfolio_category', 'br_one_portfolio', [
            'labels' => [
                'name' => __('Portfolio Categories', 'br-one'),
                'singular_name' => __('Portfolio Category', 'br-one'),
            ],
            'hierarchical' => true,
            'show_admin_column' => true,
            'rewrite' => ['slug' => 'portfolio-category'],
        ]);
    }

    public function renderSettingsPage(): void
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('onepix_options');
                do_settings_sections('br-one-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

