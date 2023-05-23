<?php

header('Content-Type: application/json; charset=utf-8');

$koneksi = mysqli_connect('localhost', 'root', '', 'daftar')

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$device = $data['device'];
$sender = $data['sender'];
$message = $data['message'];
$name = $data['name'];

$result = mysqli_query($conn, "SELECT * FROM tabel_faq WHERE tanya LIKE '%$message%'");

if (mysqli_num_rows($result) > 0) {
  $data = mysqli_fetch_assoc($result);
  $reply['message'] = "Terima kasih telah menghubungi kami,\n\n$data[jawab]";
} else {
  $reply['message'] = 'Maaf, saya tidak mengerti.';
}


function sendFonnte($target, $data) {
  $curl = curl_init('https://api.fonnte.com/send');

	curl_setopt_array($curl, [
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => [
      'target'  => $target,
      'message' => $data['message'],
    ],
	  CURLOPT_HTTPHEADER => [
	    'Authorization: LhoKkQyGomm8ETU2Bgs!',
	  ],
	]);

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
}

sendFonnte($sender, $reply);
