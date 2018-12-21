<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Exceptions;

	use Symfony\Component\Validator\ConstraintViolationInterface;
	use Symfony\Component\Validator\ConstraintViolationListInterface;

	class ConstraintViolationException extends EntityTransformerException {
		/**
		 * @var ConstraintViolationListInterface
		 */
		protected $errors;

		public function __construct(ConstraintViolationListInterface $errors) {
			$first = $errors->get(0);

			parent::__construct(
				sprintf(
					'Error validating "%s": %s (and %d other%s)',
					$first->getPropertyPath(),
					$first->getMessage(),
					$errors->count(),
					$errors->count() !== 1 ? 's' : ''
				)
			);

			$this->errors = $errors;
		}

		/**
		 * @return ConstraintViolationListInterface
		 */
		public function getErrors(): ConstraintViolationListInterface {
			return $this->errors;
		}

		/**
		 * @return array
		 */
		public function normalize(): array {
			$output = [];

			/** @var ConstraintViolationInterface $error */
			foreach ($this->getErrors() as $error) {
				$output[] = [
					'path' => $error->getPropertyPath(),
					'message' => $error->getMessage(),
					'code' => $error->getCode(),
				];
			}

			return $output;
		}
	}