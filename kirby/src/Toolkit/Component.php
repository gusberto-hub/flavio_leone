<?php

namespace Kirby\Toolkit;

use AllowDynamicProperties;
use ArgumentCountError;
use Closure;
use Kirby\Exception\Exception;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Filesystem\F;
use TypeError;

/**
 * Vue-like components
 *
 * @package   Kirby Toolkit
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      https://getkirby.com
 * @copyright Bastian Allgeier
 * @license   https://opensource.org/licenses/MIT
 *
 * @todo remove the following psalm suppress when PHP >= 8.2 required
 * @psalm-suppress UndefinedAttributeClass
 */
#[AllowDynamicProperties]
class Component
{
	/**
	 * Registry for all component mixins
	 *
	 * @var array
	 */
	public static $mixins = [];

	/**
	 * Registry for all component types
	 *
	 * @var array
	 */
	public static $types = [];

	/**
	 * An array of all passed attributes
	 *
	 * @var array
	 */
	protected $attrs = [];

	/**
	 * An array of all computed properties
	 *
	 * @var array
	 */
	protected $computed = [];

	/**
	 * An array of all registered methods
	 *
	 * @var array
	 */
	protected $methods = [];

	/**
	 * An array of all component options
	 * from the component definition
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * An array of all resolved props
	 *
	 * @var array
	 */
	protected $props = [];

	/**
	 * The component type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Magic caller for defined methods and properties
	 */
	public function __call(string $name, array $arguments = [])
	{
		if (array_key_exists($name, $this->computed) === true) {
			return $this->computed[$name];
		}

		if (array_key_exists($name, $this->props) === true) {
			return $this->props[$name];
		}

		if (array_key_exists($name, $this->methods) === true) {
			return $this->methods[$name]->call($this, ...$arguments);
		}

		return $this->$name;
	}

	/**
	 * Creates a new component for the given type
	 */
	public function __construct(string $type, array $attrs = [])
	{
		if (isset(static::$types[$type]) === false) {
			throw new InvalidArgumentException('Undefined component type: ' . $type);
		}

		$this->attrs   = $attrs;
		$this->options = $options = $this->setup($type);
		$this->methods = $methods = $options['methods'] ?? [];

		foreach ($attrs as $attrName => $attrValue) {
			$this->$attrName = $attrValue;
		}

		if (isset($options['props']) === true) {
			$this->applyProps($options['props']);
		}

		if (isset($options['computed']) === true) {
			$this->applyComputed($options['computed']);
		}

		$this->attrs   = $attrs;
		$this->methods = $methods;
		$this->options = $options;
		$this->type    = $type;
	}

	/**
	 * Improved `var_dump` output
	 */
	public function __debugInfo(): array
	{
		return $this->toArray();
	}

	/**
	 * Fallback for missing properties to return
	 * null instead of an error
	 */
	public function __get(string $attr)
	{
		return null;
	}

	/**
	 * A set of default options for each component.
	 * This can be overwritten by extended classes
	 * to define basic options that should always
	 * be applied.
	 */
	public static function defaults(): array
	{
		return [];
	}

	/**
	 * Register all defined props and apply the
	 * passed values.
	 */
	protected function applyProps(array $props): void
	{
		foreach ($props as $propName => $propFunction) {
			if ($propFunction instanceof Closure) {
				if (isset($this->attrs[$propName]) === true) {
					try {
						$this->$propName = $this->props[$propName] = $propFunction->call($this, $this->attrs[$propName]);
					} catch (TypeError) {
						throw new TypeError('Invalid value for "' . $propName . '"');
					}
				} else {
					try {
						$this->$propName = $this->props[$propName] = $propFunction->call($this);
					} catch (ArgumentCountError) {
						throw new ArgumentCountError('Please provide a value for "' . $propName . '"');
					}
				}
			} else {
				$this->$propName = $this->props[$propName] = $propFunction;
			}
		}
	}

	/**
	 * Register all computed properties and calculate their values.
	 * This must happen after all props are registered.
	 */
	protected function applyComputed(array $computed): void
	{
		foreach ($computed as $computedName => $computedFunction) {
			if ($computedFunction instanceof Closure) {
				$this->$computedName = $this->computed[$computedName] = $computedFunction->call($this);
			}
		}
	}

	/**
	 * Load a component definition by type
	 */
	public static function load(string $type): array
	{
		$definition = static::$types[$type];

		// load definitions from string
		if (is_string($definition) === true) {
			if (is_file($definition) !== true) {
				throw new Exception('Component definition ' . $definition . ' does not exist');
			}

			static::$types[$type] = $definition = F::load($definition, allowOutput: false);
		}

		return $definition;
	}

	/**
	 * Loads all options from the component definition
	 * mixes in the defaults from the defaults method and
	 * then injects all additional mixins, defined in the
	 * component options.
	 */
	public static function setup(string $type): array
	{
		// load component definition
		$definition = static::load($type);

		if (isset($definition['extends']) === true) {
			// extend other definitions
			$options = array_replace_recursive(
				static::defaults(),
				static::load($definition['extends']),
				$definition
			);
		} else {
			// inject defaults
			$options = array_replace_recursive(static::defaults(), $definition);
		}

		// inject mixins
		if (isset($options['mixins']) === true) {
			foreach ($options['mixins'] as $mixin) {
				if (isset(static::$mixins[$mixin]) === true) {
					if (is_string(static::$mixins[$mixin]) === true) {
						// resolve a path to a mixin on demand

						static::$mixins[$mixin] = F::load(static::$mixins[$mixin], allowOutput: false);
					}

					$options = array_replace_recursive(
						static::$mixins[$mixin],
						$options
					);
				}
			}
		}

		return $options;
	}

	/**
	 * Converts all props and computed props to an array
	 */
	public function toArray(): array
	{
		if (($this->options['toArray'] ?? null) instanceof Closure) {
			return $this->options['toArray']->call($this);
		}

		$array = array_merge($this->attrs, $this->props, $this->computed);

		ksort($array);

		return $array;
	}
}
