<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Exceptions;

	class EntityCloneException extends \RuntimeException {
		/**
		 * @return static
		 */
		public static function payloadRequired(): EntityCloneException {
			return new static('Cloning this entity requires additional data');
		}
	}