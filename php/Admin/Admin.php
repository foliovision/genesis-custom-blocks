<?php
/**
 * WP Admin resources.
 *
 * @package   Genesis\CustomBlocks
 * @copyright Copyright(c) 2020, Genesis Custom Blocks
 * @license   http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */

namespace Genesis\CustomBlocks\Admin;

use Genesis\CustomBlocks\ComponentAbstract;

/**
 * Class Admin
 */
class Admin extends ComponentAbstract {

	/**
	 * Plugin settings.
	 *
	 * @var Settings
	 */
	public $settings;

	/**
	 * Genesis Pro subscription.
	 *
	 * @var Subscription
	 */
	public $subscription;

	/**
	 * User onboarding.
	 *
	 * @var Onboarding
	 */
	public $onboarding;

	/**
	 * Plugin upgrade.
	 *
	 * @var Upgrade
	 */
	public $upgrade;

	/**
	 * JSON import.
	 *
	 * @var Import
	 */
	public $import;

	/**
	 * Initialise the Admin component.
	 */
	public function init() {
		$this->settings = new Settings();
		genesis_custom_blocks()->register_component( $this->settings );

		$this->subscription = new Subscription();
		genesis_custom_blocks()->register_component( $this->subscription );

		$this->onboarding = new Onboarding();
		genesis_custom_blocks()->register_component( $this->onboarding );

		/**
		 * Whether to show the pro nag.
		 *
		 * @param bool Whether this should show the nag.
		 */
		$show_pro_nag = apply_filters( 'genesis_custom_blocks_show_pro_nag', true );

		if ( $show_pro_nag && ! genesis_custom_blocks()->is_pro() ) {
			$this->upgrade = new Upgrade();
			genesis_custom_blocks()->register_component( $this->upgrade );
		} else {
			$this->maybe_settings_redirect();
		}

		if ( defined( 'WP_LOAD_IMPORTERS' ) && WP_LOAD_IMPORTERS ) {
			$this->import = new Import();
			genesis_custom_blocks()->register_component( $this->import );
		}
	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue scripts and styles used globally in the WP Admin.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style(
			'genesis-custom-blocks',
			$this->plugin->get_url( 'css/admin.css' ),
			[],
			$this->plugin->get_version()
		);
	}

	/**
	 * Redirect to the Settings screen if the subscription key is being saved.
	 */
	public function maybe_settings_redirect() {
		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );

		if ( 'genesis-custom-blocks-pro' === $page ) {
			wp_safe_redirect(
				add_query_arg(
					[
						'post_type' => 'genesis_custom_block',
						'page'      => 'genesis-custom-blocks-settings',
						'tab'       => 'subscription',
					],
					admin_url( 'edit.php' )
				)
			);

			die();
		}
	}
}