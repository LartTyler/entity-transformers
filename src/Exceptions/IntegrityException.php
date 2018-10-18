<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Exceptions;

	class IntegrityException extends EntityTransformerException {
		/**
		 * @param string $field
		 * @param string $referenceName
		 *
		 * @return static
		 */
		public static function missingReference(string $field, string $referenceName) {
			return new static(sprintf('The value of %s should be the ID of an existing %s', $field, $referenceName));
		}

		/**
		 * @param string $field
		 * @param int    $collisionId
		 *
		 * @return static
		 */
		public static function duplicateUniqueValue(string $field, int $collisionId) {
			return new static(
				sprintf('The value of %s must be a unique value, but it collides with #%d', $field, $collisionId)
			);
		}
	}