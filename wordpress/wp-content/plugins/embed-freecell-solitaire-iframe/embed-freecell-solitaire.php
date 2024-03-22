<?php
/**
 * Plugin Name: Freecell Solitaire Card Game - Embed Freecell for Free - Ad-free Freecell Puzzle game
 * Plugin URI: https://wordpress.org/plugins/embed-freecell-solitaire-iframe/
 * Description: This plugin lets you embed an ad-free version of Freecell for free using a shortcode. Easily embed Freecell Solitaire on your WordPress website, using pages and posts.
 * Version: 1.0
 * Author: onlinesolitairecardgame
 * Author URI: https://online-solitaire.com/freecell
 * License: GPL2
 */

class wp_embed_freecell {

  /* [embed-freecell]
   *  - Use this shortcode to embed the game to any page or post of website.
   */
  public static function embed_freecell($atts) {
      ob_start();
      require_once 'embed-freecell-template.php';
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
  }
}

add_shortcode( 'embed-freecell-game', Array('wp_embed_freecell', 'embed_freecell') );
