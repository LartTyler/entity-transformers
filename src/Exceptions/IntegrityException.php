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
		public static function duplicateUniqueValue(string $field, int $collisionId = null) {
			$message = sprintf('The value of %s must be unique value', $field);

			if ($collisionId !== null)
				$message .= sprintf(', but it collides with #%d', $collisionId);

			return new static($message);
		}
	}