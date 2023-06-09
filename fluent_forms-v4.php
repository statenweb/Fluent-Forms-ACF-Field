<?php

class acf_field_fluent_forms extends acf_field
{
	// vars
	var $settings, // will hold info such as dir / path
		  $defaults; // will hold default field options

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct()
	{
		// vars
		$this->name = 'fluent_forms_field';
		$this->label = __('Fluent Forms');
		$this->category = __("Relational",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array(
			'allow_multiple' => 0,
			'allow_null' => 0
		);

		// do not delete!
    parent::__construct();
	}


	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function create_options( $field )
	{
		// defaults?
		$field = array_merge($this->defaults, $field);


		// key is needed in the field names to correctly save the data
		$key = $field['name'];


		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Allow Null?",'acf'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'  =>  'radio',
			'name'  =>  'fields['.$key.'][allow_null]',
			'value' =>  $field['allow_null'],
			'choices' =>  array(
				1 =>  __("Yes",'acf'),
				0 =>  __("No",'acf'),
			),
			'layout'  =>  'horizontal',
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Select multiple values?",'acf'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'  =>  'radio',
			'name'  =>  'fields['.$key.'][multiple]',
			'value' =>  $field['multiple'],
			'choices' =>  array(
				1 =>  __("Yes",'acf'),
				0 =>  __("No",'acf'),
			),
			'layout'  =>  'horizontal',
		));
		?>
	</td>
</tr>
		<?php

	}


	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_field( $field )
	{
		// vars
		$field = array_merge($this->defaults, $field);
		$choices = array();

		if (acf_fluent_forms_active()) {
			
			$forms = acf_fluent_forms_get_all_forms();
			
		}	else {
			echo "<font style='color:red;font-weight:bold;'>Warning: Fluent Forms is not installed or activated. This field does not function without Fluent Forms!</font>";
		}
    

    if(isset($forms))
    {
    	foreach( $forms as $form )
    	{
	    	$choices[ $form->id ] = ucfirst($form->title);
    	}
    }

		// override field settings and render
		$field['choices'] = $choices;
		$field['type'] = 'select';

		do_action('acf/create_field', $field);
	}


	/*
	*  format_value_for_api()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

	function format_value_for_api( $value, $field )
    {

		//Return false if value is false, null or empty
		if( !$value || empty($value) ){
			return false;
		}
		
		//If there are multiple forms, construct and return an array of form objects
		if( is_array($value) && !empty($value) ){
			
			$form_objects = array();
			foreach($value as $k => $v){
			  $form = fluentFormApi('forms')->form($v);
			  //Add it if it's not an error object
			  if( !is_wp_error($form) ){
				  $form_objects[$k] = $form;
			  }
			}
			//Return false if the array is empty
			if( !empty($form_objects) ){
				return $form_objects;	
			}else{
				return false;
			}
			
			
		//Else return single form object
		}else{

            $form = fluentFormApi('forms')->form($value);
			//Return the form object if it's not an error object. Otherwise return false. 
			if( !is_wp_error($form) ){
				return $form;	
			}else{
				return false;
			}
			
		}

    }

}

// create field
new acf_field_fluent_forms();