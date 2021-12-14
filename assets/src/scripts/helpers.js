/**
 * Return value of object by key.
 *
 * Array is located in @module inc/Setup/Enqueue.php
 */

export function trans(key) {
  if (!selleradiseData) {
    return;
  }

  return selleradiseData.langs[key];
}

/**
 * Determines the device type by checking the width.
 */

export function device(point) {
  let match = null;

  switch (point) {
    case "mobile":
      match = "(max-width: 767px)";
      break;
    case "tablet":
      match = "(min-width: 768px) and (max-width: 1024px)";
      break;
    case "mobileAndTablet":
      match = "(max-width: 1024px)";
      break;
    case "desktop":
      match = "(min-width: 1025px)";
      break;
    case "desktopAndTablet":
      match = "(min-width: 768px)";
      break;
    default:
      match = "(min-width: 0px)";
      break;
  }

  if (match) {
    const query = window.matchMedia(match);
    return query.matches;
  }

  return false;
}

/**
 * Create tree from flat array.
 * used in one place @module assets/src/scripts/store/menu.js
 */

export function createDataTree(flat, parentKey, idKey) {
  if (flat == null) {
    return;
  }
  const root = [];
  // Cache found parent index
  const map = {};

  flat.forEach((node) => {
    // No parentId means top level
    if (!parseInt(node[parentKey])) return root.push(node);

    // Insert node as child of parent in flat array
    let parentIndex = map[parseInt(node[parentKey])];
    if (typeof parentIndex !== "number") {
      parentIndex = flat.findIndex(
        (el) => el[idKey] === parseInt(node[parentKey])
      );
      map[node.menu_item_parent] = parentIndex;
    }

    if (flat[parentIndex]) {
      if (!flat[parentIndex].hasOwnProperty("children")) {
        return (flat[parentIndex]["children"] = [node]);
      }

      flat[parentIndex]["children"].push(node);
    }
  });

  return root;
}

/**
 * Converts hex to rgb array.
 */
export function hexToRgb(hex) {
  const color = hex
    .replace(
      /^#?([a-f\d])([a-f\d])([a-f\d])$/i,
      (m, r, g, b) => "#" + r + r + g + g + b + b
    )
    .substring(1)
    .match(/.{2}/g)
    .map((x) => parseInt(x, 16));

  return color ? color : hex;
}
/**
 * Return the luminance of color from rgb.
 */

export function luminance(r, g, b) {
  var a = [r, g, b].map(function (v) {
    v /= 255;
    return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
  });
  return a[0] * 0.2126 + a[1] * 0.7152 + a[2] * 0.0722;
}

/**
 * Calculates contrast ratio between two rgb colors.
 */

export function calculateContrastRatio(color1, color2) {
  var lum1 = luminance(color1[0], color1[1], color1[2]);
  var lum2 = luminance(color2[0], color2[1], color2[2]);
  var brightest = Math.max(lum1, lum2);
  var darkest = Math.min(lum1, lum2);
  return (brightest + 0.05) / (darkest + 0.05);
}

/**
 * Calculates contrast ratio between two luminance values.
 */

export function calculateContrastRatioLuminance(lum1, lum2) {
  var brightest = Math.max(lum1, lum2);
  var darkest = Math.min(lum1, lum2);
  return (brightest + 0.05) / (darkest + 0.05);
}

/**
 * colorChannelA and colorChannelB are integers ranging from 0 to 255
 */
export function colorChannelMixer(colorChannelA, colorChannelB, amountToMix) {
  var channelA = colorChannelA * amountToMix;
  var channelB = colorChannelB * (1 - amountToMix);
  return parseInt(channelA + channelB);
}

/**
 * rgbA and rgbB are arrays, amountToMix ranges from 0.0 to 1.0.
 * Example (red): rgbA = [255,0,0]
 */

export function colorMixer(rgbA, rgbB, amountToMix = 0.8) {
  var r = colorChannelMixer(rgbA[0], rgbB[0], amountToMix);
  var g = colorChannelMixer(rgbA[1], rgbB[1], amountToMix);
  var b = colorChannelMixer(rgbA[2], rgbB[2], amountToMix);
  return r + "," + g + "," + b;
}
