<?php
	namespace DaybreakStudios\Utility\EntityTransformers\Utility;

	final class StringUtil {
		/**
		 * @param string $string
		 *
		 * @return string
		 */
		public static function getIndefiniteArticle(string $string): string {
			if (strlen($string) === 0)
				return '';

			$char = trim($string)[0];

			if (in_array($char, ['a', 'e', 'i', 'o', 'u']))
				return 'an';

			return 'a';
		}
	}