<?php
	namespace DaybreakStudios\Utility\EntityTransformers;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use DaybreakStudios\Utility\EntityTransformers\Exceptions\ConstraintViolationException;
	use DaybreakStudios\Utility\EntityTransformers\Exceptions\IntegrityException;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\Validator\Validator\ValidatorInterface;

	abstract class AbstractEntityTransformer implements EntityTransformerInterface {
		/**
		 * @var EntityManagerInterface
		 */
		protected $entityManager;

		/**
		 * @var ValidatorInterface|null
		 */
		private $validator;

		/**
		 * AbstractEntityTransformer constructor.
		 *
		 * @param EntityManagerInterface  $entityManager
		 * @param ValidatorInterface|null $validator
		 */
		public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator = null) {
			$this->entityManager = $entityManager;
			$this->validator = $validator;
		}

		/**
		 * {@inheritdoc}
		 */
		public function create(object $data, bool $skipValidation = false): EntityInterface {
			$entity = $this->doCreate($data);
			$this->update($entity, $data, true);

			if (!$skipValidation)
				$this->validate($entity);

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
		 * @param EntityInterface $entity
		 * @param object          $data
		 * @param bool            $skipValidation
		 *
		 * @return void
		 */
		public function update(EntityInterface $entity, object $data, bool $skipValidation = false): void {
			$this->doUpdate($entity, $data);

			if (!$skipValidation)
				$this->validate($entity);
		}

		/**
		 * @param EntityInterface $entity
		 * @param object          $data
		 *
		 * @return void
		 */
		public abstract function doUpdate(EntityInterface $entity, object $data): void;

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

		/**
		 * @param EntityInterface $entity
		 *
		 * @return void
		 */
		protected function validate(EntityInterface $entity): void {
			if (!$this->validator)
				return;

			$errors = $this->validator->validate($entity);

			if ($errors->count())
				throw new ConstraintViolationException($errors);
		}
	}