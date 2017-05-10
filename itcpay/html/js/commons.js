/**
 * Created by Naman Attri on 8/29/2016.
 */


/**
 * roundToPlaces
 *
 * function to round a number to the number of decimal places
 * created Aug 26, 2016
 *
 * @author NA
 */
function roundToPlaces(val, round) {
    return parseFloat(Math.round(val * Math.pow(10, round))/Math.pow(10, round)).toFixed(2);
}