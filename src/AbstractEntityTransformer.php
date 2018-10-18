<?php
	namespace DaybreakStudios\Utility\EntityTransformers;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use DaybreakStudios\Utility\EntityTransformers\Exceptions\IntegrityException;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\EntityManagerInterface;

	abstract class AbstractEntityTransformer implements EntityTransformerInterface {
		/**
		 * @var EntityManagerInterface
		 */
		protected $entityManager;

		/**
		 * AbstractEntityTransformer constructor.
		 *
		 * @param EntityManagerInterface $entityManager
		 */
		public function __construct(EntityManagerInterface $entityManager) {
			$this->entityManager = $entityManager;
		}

		/**
		 * {@inheritdoc}
		 */
		public function create(object $data): EntityInterface {
			$entity = $this->doCreate($data);
			$this->update($entity, $data);

			$this->entityManager->persist($entity);

			return $entity;
		}

		/**
		 * @param object $data
		 *
		 * @return EntityInterface
		 */
		public abstract function doCreate(object $data): EntityInterface;

		/**
		 * {@inheritdoc}
		 */
		public function delete(EntityInterface $entity): void {
			$this->doDelete($entity);

			$this->entityManager->remove($entity);
		}

		/**
		 * @param EntityInterface $entity
		 *
		 * @return void
		 */
		public abstract function doDelete(EntityInterface $entity): void;

		/**
		 * @param string     $path
		 * @param Collection $collection
		 * @param string     $class
		 * @param int[]      $ids
		 *
		 * @return void
		 */
		protected function populateFromIdArray(string $path, Collection $collection, string $class, array $ids): void {
			$collection->clear();

			foreach ($ids as $index => $id) {
				$value = $this->entityManager->getRepository($class)->find($id);

				if (!$value) {
					$name = substr($class, strrpos($class, '\\') + 1);

					throw IntegrityException::missingReference($path . '[' . $index . ']', $name);
				}

				$collection->add($value);
			}
		}
	}