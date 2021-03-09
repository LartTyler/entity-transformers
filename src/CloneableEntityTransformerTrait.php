<?php
	namespace DaybreakStudios\Utility\EntityTransformers;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use DaybreakStudios\Utility\EntityTransformers\Exceptions\EntityCloneException;
	use Doctrine\ORM\EntityManagerInterface;

	/**
	 * For use with {@see CloneableEntityTransformerInterface}.
	 */
	trait CloneableEntityTransformerTrait {
		/**
		 * @var EntityManagerInterface
		 */
		protected $entityManager;

		/**
		 * @var bool
		 */
		protected $allowNullClonePayload = true;

		/**
		 * @param EntityInterface $source
		 * @param object|null     $data
		 * @param bool            $skipValidation
		 *
		 * @return EntityInterface
		 */
		public function clone(
			EntityInterface $source,
			?object $data = null,
			bool $skipValidation = false
		): EntityInterface {
			if (!$this->allowNullClonePayload && $data === null)
				throw EntityCloneException::payloadRequired();

			$cloned = clone $source;
			$this->doClone($cloned, $data);

			if (!$skipValidation)
				$this->validate($cloned);

			$this->entityManager->persist($cloned);

			return $cloned;
		}

		/**
		 * @param EntityInterface $entity
		 * @param object|null     $data
		 *
		 * @return void
		 */
		protected function doClone(EntityInterface $entity, ?object $data = null): void {
			// Override this method if cloning the entity requires more logic than just invoking the `__clone()` magic
			// method.
		}

		/**
		 * @param EntityInterface $entity
		 *
		 * @return void
		 * @see AbstractEntityTransformer::validate()
		 */
		protected function validate(EntityInterface $entity): void {
			// Stub method to allow optional validation. This method should be overridden with whatever validation logic
			// your application requires.
		}
	}