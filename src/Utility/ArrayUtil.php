<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Utility;

	final class ArrayUtil {
		/**
		 * ArrayUtil constructor.
		 */
		private function __construct() {
		}

		/**
		 * @param array $data
		 * @param array $required
		 *
		 * @return array
		 */
		public static function getMissingFields(array $data, array $required) {
			$missing = [];

			foreach ($required as $field) {
				if (!self::isset($data, $field))
					$missing[] = $field;
			}

			return $missing;
		}

		/**
		 * @param array  $array
		 * @param string $key
		 *
		 * @return bool
		 */
		public static function isset(array $array, string $key): bool {
			return isset($array[$key]) || array_key_exists($key, $array);
		}
	}