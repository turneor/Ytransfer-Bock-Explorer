<?php

$data_string = '{"jsonrpc":"2.0","id":"test","method":"getlastblockheader","params":" "}';

$ch = curl_init('http://52.87.163.163:32888/json_rpc');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);

// print_r($result);

// Decode the response
$responseData = json_decode($result, TRUE);

// Print the date from the response
// print_r($responseData);

$hash = $responseData['result']['block_header']['hash'];

//print_r($hash);
curl_close($ch);

$data_string2 = '{"jsonrpc":"2.0","id":"test","method":"f_block_json","params":{"hash":"'.$hash.'"}}';


$ch2 = curl_init('http://52.87.163.163:32888/json_rpc');
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string2))
);

$block = curl_exec($ch2);

// Decode the response
$blockData = json_decode($block, TRUE);


$supply = $blockData[result][block][alreadyGeneratedCoins];

$supply  = number_format($supply / 1000000, 6, ".", "");

curl_close($ch2);

$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_URL, 'http://52.87.163.163:32888/getinfo');
$result = curl_exec($ch3);
$getinfo = json_decode($result, TRUE);
curl_close($ch3);

$depamnt = $getinfo['full_deposit_amount'];

$depamnt = number_format($depamnt / 1000000, 6, ".", "");

print_r($supply - $depamnt);
?>
