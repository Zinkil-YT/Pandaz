<?php

declare(strict_types=1);

namespace Zinkil\\Pandaz\misc;


use pocketmine\level\Location;
use pocketmine\math\Vector3;

class Math{

	/**
	 * @param $value
	 * @param $minValue
	 *
	 * @return mixed
	 *
	 * Returns value if greater than minValue, otherwise return minValue.
	 */
	public static function floor($value, $minValue){
		return $value <= $minValue ? $minValue : $value;
	}

	/**
	 * @param $value
	 * @param $maxValue
	 *
	 * @return mixed
	 *
	 * Returns value if less than maxValue, otherwise return maxValue.
	 */
	public static function ceil($value, $maxValue){
		return $value >= $maxValue ? $maxValue : $value;
	}

	/**
	 * @param $value - The value we are clamping.
	 * @param $min - The minimum value.
	 * @param $max - The maximum value.
	 *
	 * @return mixed
	 *
	 * Clamps the value between a minimum and a maximum.
	 */
	public static function clamp($value, $min, $max){
		if($value <= $min){
			return $min;
		}else if($value >= $max){
			return $max;
		}
		return $value;
	}

	/**
	 * @param Vector3 $a - Direction vector a.
	 * @param Vector3 $b - Direction vector b.
	 *
	 * @return float
	 *
	 * The dot product between two vector3s.
	 * -> If value == 1, then b is parallel to a in same direction.
	 * -> If value == -1, then b is parallel to a in opposite direction.
	 */
	public static function dot(Vector3 $a, Vector3 $b) : float{
		return $a->x * $b->x + $a->y * $b->y + $a->z * $b->z;
	}

	/**
	 * Linearly interpolates between a & b by the alpha.
	 *
	 * @param float|Vector3|Location $a - The a value.
	 * @param float|Vector3|Location $b - The b value.
	 * @param float                  $alpha - The alpha we are interpolating by.
	 *
	 * @return float|Vector3|Location|null - returns null if unsuccessful.
	 */
	public static function lerp($a, $b, float $alpha){
		if(is_float($a) && is_float($b)){
			return $a + ($b - $a) * $alpha;
		}

		if($a instanceof Vector3 && $b instanceof Vector3){
			$newX = self::lerp($a->x, $b->x, $alpha);
			$newY = self::lerp($a->y, $b->y, $alpha);
			$newZ = self::lerp($a->z, $b->z, $alpha);

			if($a instanceof Location && $b instanceof Location){
				$yaw = self::lerp($a->yaw, $b->yaw, $alpha);
				$pitch = self::lerp($a->pitch, $b->pitch, $alpha);
				return new Location($newX, $newY, $newZ, $yaw, $pitch, $a->getLevel());
			}
			return new Vector3($newX, $newY, $newZ);
		}
		return null;
	}
}