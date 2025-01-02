<?php
namespace EasyRoadmap\Abstract;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract Field Class
 */
abstract class Field {

	protected $id = '';

	protected $label = '';

	protected $value = '';

	protected $description = '';

	protected $cols = 1;

	protected $placeholder = '';

	protected $options = array();

	protected $default = '';

	protected $disabled = false;

	protected $readonly = false;

	protected $type = 'text';

	protected $class = '';

	protected $multiple = false;

	public function __construct( $config = array() ) {
		$this->id          = $config['id'] ?? '';
		$this->label       = $config['label'] ?? '';
		$this->value       = $config['value'] ?? '';
		$this->description = $config['description'] ?? '';
		$this->cols        = $config['cols'] ?? 1;
		$this->placeholder = $config['placeholder'] ?? '';
		$this->options     = $config['options'] ?? array();
		$this->default     = $config['default'] ?? '';
		$this->disabled    = $config['disabled'] ?? false;
		$this->readonly    = $config['readonly'] ?? false;
		$this->type        = $config['type'] ?? 'text';
		$this->class       = $config['class'] ?? '';
		$this->multiple    = $config['multiple'] ?? false;
	}

	/**
	 * Set whether the field supports multiple selections.
	 *
	 * @param bool $multiple
	 */
	public function set_multiple( $multiple = false ) {
		$this->multiple = $multiple;
	}

	/**
	 * Get whether the field supports multiple selections.
	 *
	 * @return bool
	 */
	public function is_multiple() {
		return $this->multiple;
	}

	/**
	 * Get the field ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get the field label.
	 *
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * Get the field value.
	 *
	 * @return string
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Get the field description.
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get the field column size.
	 *
	 * @return int
	 */
	public function get_cols() {
		return $this->cols;
	}

	/**
	 * Get the field placeholder.
	 *
	 * @return string
	 */
	public function get_placeholder() {
		return $this->placeholder;
	}

	/**
	 * Get the field options.
	 *
	 * @return array
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Get the field default value.
	 *
	 * @return mixed
	 */
	public function get_default() {
		return $this->default;
	}

	/**
	 * Check if the field is disabled.
	 *
	 * @return bool
	 */
	public function is_disabled() {
		return $this->disabled;
	}

	/**
	 * Check if the field is readonly.
	 *
	 * @return bool
	 */
	public function is_readonly() {
		return $this->readonly;
	}

	/**
	 * Get the field type.
	 *
	 * @return string
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Get the field class.
	 *
	 * @return string
	 */
	public function get_class() {
		return $this->class;
	}

	/**
	 * Set the field value.
	 *
	 * @param string $value
	 */
	public function set_value( $value = '' ) {
		$this->value = $value;
	}

	/**
	 * Set the field description.
	 *
	 * @param string $description
	 */
	public function set_description( $description = '' ) {
		$this->description = $description;
	}

	/**
	 * Set the field column size.
	 *
	 * @param int $cols
	 */
	public function set_cols( $cols = 1 ) {
		$this->cols = $cols;
	}

	/**
	 * Set the field placeholder.
	 *
	 * @param string $placeholder
	 */
	public function set_placeholder( $placeholder = '' ) {
		$this->placeholder = $placeholder;
	}

	/**
	 * Set the field options.
	 *
	 * @param array $options
	 */
	public function set_options( $options = array() ) {
		$this->options = $options;
	}

	/**
	 * Set the field default value.
	 *
	 * @param mixed $default
	 */
	public function set_default( $default = '' ) {
		$this->default = $default;
	}

	/**
	 * Set the field disabled state.
	 *
	 * @param bool $disabled
	 */
	public function set_disabled( $disabled = false ) {
		$this->disabled = $disabled;
	}

	/**
	 * Set the field readonly state.
	 *
	 * @param bool $readonly
	 */
	public function set_readonly( $readonly = false ) {
		$this->readonly = $readonly;
	}

	/**
	 * Set the field type.
	 *
	 * @param string $type
	 */
	public function set_type( $type = 'text' ) {
		$this->type = $type;
	}

	/**
	 * Set the field class.
	 *
	 * @param string $class
	 */
	public function set_class( $class = '' ) {
		$this->class = $class;
	}

	/**
	 * Generate the CSS ID for the field.
	 *
	 * @return string
	 */
	public function get_field_id() {
		return 'easyroadmap-field-' . $this->id;
	}

	/**
	 * Generate the CSS class for the field.
	 *
	 * @return string
	 */
	public function get_field_class() {
		return 'easyroadmap-field easyroadmap-field-' . $this->type;
	}

	/**
	 * Generate the CSS ID for the field wrapper.
	 *
	 * @return string
	 */
	public function get_wrapper_id() {
		return 'easyroadmap-field-wrapper-' . $this->id;
	}

	/**
	 * Generate the CSS class for the field wrapper.
	 *
	 * @return string
	 */
	public function get_wrapper_class() {
		return 'easyroadmap-field-wrapper easyroadmap-field-wrapper-' . $this->type . ' ' . $this->class;
	}

	/**
	 * Render the field.
	 *
	 * @return string
	 */
	abstract public function render();
}
