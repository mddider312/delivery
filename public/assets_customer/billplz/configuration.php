<?php
/**
 * Instruction:
 *
 * 1. Replace the APIKEY with your API Key.
 * 2. OPTIONAL: Replace the COLLECTION with your Collection ID.
 * 3. Replace the X_SIGNATURE with your X Signature Key
 * 4. Replace the http://www.google.com/ with your FULL PATH TO YOUR WEBSITE. It must be end with trailing slash "/".
 * 5. Replace the http://www.google.com/success.html with your FULL PATH TO YOUR SUCCESS PAGE. *The URL can be overridden later
 * 6. OPTIONAL: Set $amount value.
 * 7. OPTIONAL: Set $fallbackurl if the user are failed to be redirected to the Billplz Payment Page.
 *
 */

//FOR LIVE USE
$api_key = '07518e72-16d2-42ec-9ac3-5bcb7a82a972';
$collection_id = 'zast9yuv';
$x_signature = 'S-uFgwVUUVHF--Ij5Cb5jrRA';

//FOR TESTING USE
/*
$api_key = '6c4b86d5-1d59-47ed-bd11-d6327ce2d49d';
$collection_id = 'ggovpepb';
$x_signature = 'S-9kk1EEfmwCQLLme8otR7vQ';
*/
$websiteurl = 'http://gardenfanaticstore.com.my/billplz/';
$successpath = 'http://gardenfanaticstore.com.my/shop.php?page=1';
$amount = ''; //Example (RM13.50): $amount = '1350';
$fallbackurl = ''; //Example: $fallbackurl = 'http://www.google.com/pay.php';
$description = 'PAYMENT DESCRIPTION';
$reference_1_label = '';
$reference_2_label = '';
