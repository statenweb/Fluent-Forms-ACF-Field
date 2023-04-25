<?php
/*
Plugin Name: Advanced Custom Fields: Fluent Forms Field
Plugin URI: https://github.com/matgargano/Fluent-Forms-ACF-Field
Description: ACF field to select one or many Fluent Forms
Version: 0.0.1
Author: @matgargano of @statenweb
Author URI: http://www.statenweb.com
License: MIT
License URI: http://opensource.org/licenses/MIT
*/

// $version = 5 and can be ignored until ACF6 exists
function include_field_types_Fluent_Forms( $version ) {

  include_once('fluent_forms-v5.php');

}

add_action('acf/include_field_types', 'include_field_types_fluent_forms');


function register_fields_Fluent_Forms() {
  include_once('fluent_forms-v4.php');
}

add_action('acf/register_fields', 'register_fields_fluent_forms');

function acf_fluent_forms_active(){
    return defined('FLUENTFORM');
}

function acf_fluent_forms_get_all_forms(){
    if(!function_exists('fluentFormApi')){
        return;
    }
    $formApi = fluentFormApi('forms');

    $atts = [
        'status' => 'published',
        'sort_column' => 'id',
        'sort_by' => 'DESC',
        'per_page' => 1000,
        'page' => 1
    ];
    $forms = $formApi->forms($atts, false);
    if(!empty($forms['data']) && is_array($forms['data'])) {
        return array_map(function($form_obj){
            return (object)array(
                'id' => $form_obj->id,
                'title' => $form_obj->title
            );
        }, $forms['data']);
    }
    return array();
}

//Added to check if Fluent Forms is installed on activation.
function acf_fluent_forms_activate() {

    if (acf_fluent_forms_active()) {

			return true;

		}	else {

			$html = '<div class="error">';
				$html .= '<p>';
					$html .= _e( 'Warning: Fluent Forms is not installed or activated. This plugin does not function without Fluent Forms!' );
				$html .= '</p>';
			$html .= '</div>';
			echo $html;

		}
}
register_activation_hook( __FILE__, 'acf_fluent_forms_activate' );
