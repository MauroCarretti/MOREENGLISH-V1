<?php

if ( ! class_exists( 'EduBlink_Mega_Menu_Extend' ) ) :
    class EduBlink_Mega_Menu_Extend extends Walker_Nav_Menu_Edit  {
        
        public function start_lvl( &$output, $depth = 0, $args = array() ) {}
        
        public function end_lvl( &$output, $depth = 0, $args = array() ) {}

        public function start_el(&$output, $item, $depth=0, $args=array(), $current_object_id=0) {

            $item_output = '';

            parent::start_el( $item_output, $item, $depth, $args, $current_object_id );

            $output .= preg_replace(
                // NOTE: Check this regex from time to time!
                '/(?=<(fieldset|p)[^>]+class="[^"]*field-move)/',
                $this->get_fields( $item, $depth, $args ),
                $item_output
            );
        }

        protected function get_fields( $item, $depth, $args = array(), $id = 0 ) {
            ob_start();
            
            if( $depth == 0 ) :
                do_action( 'edublink_custom_options_for_megamenu', $item->ID, $item, $depth, $args, $id );
            endif;

            return ob_get_clean();
        }
    }
endif;