<?php
namespace HappyMap;

class Frontend {
    public function __construct() {
        add_shortcode( HAPPYMAP_SHORTCODE_NAME, [ $this, "shortcode" ] );
    }

    private function get_globals() {
        $globals = [
            "version" => HAPPYMAP_PLUGIN_VERSION
        ];
        return $globals;
    }

    private function init() {
        wp_enqueue_style( "happymap-main", HAPPYMAP_PLUGIN_URL . "assets/css/main.css", [], HAPPYMAP_PLUGIN_VERSION );
        wp_enqueue_script( "happymap-main", HAPPYMAP_PLUGIN_URL . "assets/js/main.js", ["jquery"], HAPPYMAP_PLUGIN_VERSION, true );
        wp_localize_script( "happymap-main", "happymap_globals", $this->get_globals() );
    }

    private function sanitizeWidthHeight( $value ) {
        $sanitized_value = preg_replace("/[^0-9.%pxrememvwvh]/", "", $value);

        if ( strpos($sanitized_value, "%" ) !== false ) {
            $numeric_value = (float) filter_var( $sanitized_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $sanitized_value = min($numeric_value, 100) . "%";
        }

        if ( strpos($sanitized_value, "." ) !== false ) {
            $numeric_value = (float) filter_var( $sanitized_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $sanitized_value = round( $numeric_value, 2 );
        }

        return $sanitized_value;
    }

    private function sanitizeClass( $class ) {
        $sanitized_class = preg_replace("/[^a-zA-Z0-9-_]/", "", $class);
        return $sanitized_class;
    }

    public function shortcode( $atts = [] ) {
        $atts = array_change_key_case( $atts, CASE_LOWER );
        $defaults = [
            "lat"    => null,
            "long"   => null,
            "class"  => null,
            "width"  => null,
            "height" => null
        ];
        $atts = shortcode_atts( $defaults, $atts );

        if ( $atts["lat"] == null || $atts["long"] == null ) {
            return;
        }

        $lat = floatval( $atts["lat"] );
        $long = floatval( $atts["long"] );
        $width = $atts["width"] !== null ? $this->sanitizeWidthHeight( $atts["width"] ) : null;
        $height = $atts["height"] !== null ? $this->sanitizeWidthHeight( $atts["height"] ) : null;
        $class = $atts["class"] !== null ? $this->sanitizeClass( $atts["class"] ) : null;

        $this->init();

        $inlineStyles = $width !== null ? "width:{$width};" : "";
        $inlineStyles .= $height !== null ? "height:{$height};" : "";

        return "<div class='happymap" . ( $class !== null ? " {$class}" : "" ) . "'" .  ( !empty( $inlineStyles ) ? " style='{$inlineStyles}'" : "" ) . "data-lat='{$lat}' data-long='{$long}'></div>";
    }
}