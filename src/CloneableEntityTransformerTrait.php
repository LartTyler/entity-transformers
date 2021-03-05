<?php
	namespace DaybreakStudios\Utility\EntityTransformers;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
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
		 * @param EntityInterface $entity
		 * @param object|null     $data
		 * @param bool            $skipValidation
		 *
		 * @return EntityInterface
		 */
		public function clone(
			EntityInterface $entity,
			?object $data = null,
			bool $skipValidation = false
		): EntityInterface {
			$cloned = clone $entity;
			$this->doClone($entity, $data);

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
		protected abstract function doClone(EntityInterface $entity, ?object $data = null): void;

		/**
		 * @param EntityInterface $entity
		 *
		 * @return void
		 */
		protected abstract function validate(EntityInterface $entity): void;
	}