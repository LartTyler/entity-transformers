<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Exceptions;

	/**
	 * Parent exception class for all transformer exceptions.
	 */
	class EntityTransformerException extends \RuntimeException {
		/**
		 * @param mixed $subject
		 *
		 * @return EntityTransformerException
		 */
		public static function subjectNotSupported($subject) {
			$name = is_object($subject) ? get_class($subject) : gettype($subject);

			return new static('This transformer does not support transforming ' . $name);
		}
	}