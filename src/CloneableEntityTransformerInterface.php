<?php
	namespace DaybreakStudios\Utility\EntityTransformers;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use DaybreakStudios\Utility\EntityTransformers\Exceptions\ValidationException;

	interface CloneableEntityTransformerInterface {
		/**
		 * Clones the given entity. It is highly recommended that you implement the `__clone` magic method
		 * (https://www.php.net/manual/en/language.oop5.cloning.php), especially if you're cloning Doctrine objects.
		 * Please note that this method will persist the cloned entity to Doctrine, but will NOT flush any changes.
		 *
		 * If any of the following exceptions are thrown, no changes will be written to the database.
		 *
		 * A {@see ValidationException} will be thrown if any of the following conditions are met.
		 *     - Any value does not match it's expected type.
		 *
		 * @param EntityInterface $entity
		 * @param object|null     $data
		 * @param bool            $skipValidation
		 *
		 * @return EntityInterface
		 */
		public function clone(EntityInterface $entity, ?object $data = null, bool $skipValidation = false): EntityInterface;
	}