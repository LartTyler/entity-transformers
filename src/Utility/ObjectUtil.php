<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Utility;

	final class ObjectUtil {
		/**
		 * ObjectUtil constructor.
		 */
		private function __construct() {
		}

		/**
		 * @param object $object
		 * @param array  $properties
		 *
		 * @return array
		 */
		public static function getMissingProperties(object $object, array $properties): array {
			$missing = [];

			foreach ($properties as $property) {
				if (!ObjectUtil::isset($object, $property))
					$missing[] = $property;
			}

			return $missing;
		}

		/**
		 * @param object $object
		 * @param string $key
		 *
		 * @return bool
		 */
		public static function isset(object $object, string $key): bool {
			return isset($object->{$key}) || property_exists($object, $key);
		}
	}