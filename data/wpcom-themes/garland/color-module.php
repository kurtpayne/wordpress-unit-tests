<?php
/**
 * Shift a given color, using a reference pair and a target blend color.
 *
 * Note: this function is significantly different from the JS version, as it
 * is written to match the blended images perfectly.
 *
 * Constraint: if (ref2 == target + (ref1 - target) * delta) for some fraction delta
 *              then (return == target + (given - target) * delta)
 *
 * Loose constraint: Preserve relative positions in saturation and luminance
 *                   space.
 */
function _color_shift($given, $ref1, $ref2, $target) {

  // We assume that ref2 is a blend of ref1 and target and find
  // delta based on the length of the difference vectors:

  // delta = 1 - |ref2 - ref1| / |white - ref1|
  $target = _color_unpack($target, true);
  $ref1 = _color_unpack($ref1, true);
  $ref2 = _color_unpack($ref2, true);
  for ($i = 0; $i < 3; ++$i) {
    $numerator += ($ref2[$i] - $ref1[$i]) * ($ref2[$i] - $ref1[$i]);
    $denominator += ($target[$i] - $ref1[$i]) * ($target[$i] - $ref1[$i]);
  }
  $delta = ($denominator > 0) ? (1 - sqrt($numerator / $denominator)) : 0;

  // Calculate the color that ref2 would be if the assumption was true.
  for ($i = 0; $i < 3; ++$i) {
    $ref3[$i] = $target[$i] + ($ref1[$i] - $target[$i]) * $delta;
  }

  // If the assumption is not true, there is a difference between ref2 and ref3.
  // We measure this in HSL space. Notation: x' = hsl(x).
  $ref2 = _color_rgb2hsl($ref2);
  $ref3 = _color_rgb2hsl($ref3);
  for ($i = 0; $i < 3; ++$i) {
    $shift[$i] = $ref2[$i] - $ref3[$i];
  }

  // Take the given color, and blend it towards the target.
  $given = _color_unpack($given, true);
  for ($i = 0; $i < 3; ++$i) {
    $result[$i] = $target[$i] + ($given[$i] - $target[$i]) * $delta;
  }

  // Finally, we apply the extra shift in HSL space.
  // Note: if ref2 is a pure blend of ref1 and target, then |shift| = 0.
  $result = _color_rgb2hsl($result);
  for ($i = 0; $i < 3; ++$i) {
    $result[$i] = min(1, max(0, $result[$i] + $shift[$i]));
  }
  $result = _color_hsl2rgb($result);

  // Return hex color.
  return _color_pack($result, true);
}

/**
 * Convert a hex triplet into a GD color.
 */
function _color_gd($img, $hex) {
  $c = array_merge(array($img), _color_unpack($hex));
  return call_user_func_array('imagecolorallocate', $c);
}

/**
 * Blend two hex colors and return the GD color.
 */
function _color_blend($img, $hex1, $hex2, $alpha) {
  $in1 = _color_unpack($hex1);
  $in2 = _color_unpack($hex2);
  $out = array($img);
  for ($i = 0; $i < 3; ++$i) {
    $out[] = $in1[$i] + ($in2[$i] - $in1[$i]) * $alpha;
  }
  return call_user_func_array('imagecolorallocate', $out);
}

/**
 * Convert a hex color into an RGB triplet.
 */
function _color_unpack($hex, $normalize = false) {
  if (strlen($hex) == 4) {
    $hex = $hex[1] . $hex[1] . $hex[2] . $hex[2] . $hex[3] . $hex[3];
  }
  $c = hexdec($hex);
  for ($i = 16; $i >= 0; $i -= 8) {
    $out[] = (($c >> $i) & 0xFF) / ($normalize ? 255 : 1);
  }
  return $out;
}

/**
 * Convert an RGB triplet to a hex color.
 */
function _color_pack($rgb, $normalize = false) {
  foreach ($rgb as $k => $v) {
    $out |= (($v * ($normalize ? 255 : 1)) << (16 - $k * 8));
  }
  return '#'. str_pad(dechex($out), 6, 0, STR_PAD_LEFT);
}

/**
 * Convert a HSL triplet into RGB
 */
function _color_hsl2rgb($hsl) {
  $h = $hsl[0];
  $s = $hsl[1];
  $l = $hsl[2];
  $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
  $m1 = $l * 2 - $m2;
  return array(_color_hue2rgb($m1, $m2, $h + 0.33333),
               _color_hue2rgb($m1, $m2, $h),
               _color_hue2rgb($m1, $m2, $h - 0.33333));
}

/**
 * Helper function for _color_hsl2rgb().
 */
function _color_hue2rgb($m1, $m2, $h) {
  $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
  if ($h * 2 < 1) return $m2;
  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
  return $m1;
}

/**
 * Convert an RGB triplet to HSL.
 */
function _color_rgb2hsl($rgb) {
  $r = $rgb[0];
  $g = $rgb[1];
  $b = $rgb[2];
  $min = min($r, min($g, $b));
  $max = max($r, max($g, $b));
  $delta = $max - $min;
  $l = ($min + $max) / 2;
  $s = 0;
  if ($l > 0 && $l < 1) {
    $s = $delta / ($l < 0.5 ? (2 * $l) : (2 - 2 * $l));
  }
  $h = 0;
  if ($delta > 0) {
    if ($max == $r && $max != $g) $h += ($g - $b) / $delta;
    if ($max == $g && $max != $b) $h += (2 + ($b - $r) / $delta);
    if ($max == $b && $max != $r) $h += (4 + ($r - $g) / $delta);
    $h /= 6;
  }
  return array($h, $s, $l);
}
?>
