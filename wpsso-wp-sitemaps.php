<?php
/**
 * Plugin Name: WPSSO WP Sitemaps XML
 * Plugin Slug: wpsso-wp-sitemaps
 * Text Domain: wpsso-wp-sitemaps
 * Domain Path: /languages
 * Plugin URI: https://wpsso.com/extend/plugins/wpsso-wp-sitemaps/
 * Assets URI: https://surniaulula.github.io/wpsso-wp-sitemaps/assets/
 * Author: JS Morisset
 * Author URI: https://wpsso.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Manage post and taxonomy types included in the WordPress sitemaps XML and exclude content marked as "No Index".
 * Requires PHP: 7.2
 * Requires At Least: 5.5
 * Tested Up To: 5.9.1
 * WC Tested Up To: 6.2.0
 * Version: 2.1.0
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 * 
 * Copyright 2014-2022 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WpssoAbstractAddOn' ) ) {

	require_once dirname( __FILE__ ) . '/lib/abstract/add-on.php';
}

if ( ! class_exists( 'WpssoWpsm' ) ) {

	class WpssoWpsm extends WpssoAbstractAddOn {

		public $filters;	// WpssoWpsmFilters class object.
		public $sitemaps;	// WpssoWpsmSitemaps class object.

		protected $p;		// Wpsso class object.

		private static $instance = null;	// WpssoWpsm class object.

		public function __construct() {

			parent::__construct( __FILE__, __CLASS__ );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'wpsso-wp-sitemaps', false, 'wpsso-wp-sitemaps/languages/' );
		}

		public function init_objects() {

			$this->p =& Wpsso::get_instance();

			if ( $this->p->debug->enabled ) {

				$this->p->debug->mark();
			}

			if ( $this->get_missing_requirements() ) {	// Returns false or an array of missing requirements.

				return;	// Stop here.
			}

			$this->filters  = new WpssoWpsmFilters( $this->p, $this );
			$this->sitemaps = new WpssoWpsmSitemaps( $this->p, $this );
		}
	}

	WpssoWpsm::get_instance();
}
