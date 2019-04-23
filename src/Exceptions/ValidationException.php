<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Exceptions;

	use DaybreakStudios\Utility\EntityTransformers\Utility\StringUtil;

	class ValidationException extends EntityTransformerException {
		/**
		 * @param string $field
		 * @param string $explanation
		 *
		 * @return ValidationException
		 */
		public static function invalidFieldValue(string $field, string $explanation) {
			return new static(
				sprintf(
					'You provided an invalid value for %s; %s',
					$field,
					$explanation
				)
			);
		}

		/**
		 * @param string $field
		 * @param string $expected
		 *
		 * @return ValidationException
		 */
		public static function invalidFieldType(string $field, string $expected) {
			return static::invalidFieldValue(
				$field,
				sprintf('It should be %s %s', StringUtil::getIndefiniteArticle($expected), $expected)
			);
		}

		/**
		 * @param array $fields
		 *
		 * @return ValidationException
		 */
		public static function missingFields(array $fields) {
			return new static(
				sprintf('You must provide a value for the following field(s): [%s]', implode(', ', $fields))
			);
		}

		/**
		 * @param string $prefix
		 * @param int    $index
		 * @param array  $keys
		 *
		 * @return ValidationException
		 */
		public static function missingNestedFields(string $prefix, int $index, array $keys) {
			return static::missingFields(
				array_map(
					function(string $key) use ($prefix, $index) {
						return $prefix . '[' . $index . '].' . $key;
					},
					$keys
				)
			);
		}

		/**
		 * @param string $field
		 *
		 * @return ValidationException
		 */
		public static function fieldNotSupported(string $field) {
			return new static('The transformer does not support updates to ' . $field);
		}
	}