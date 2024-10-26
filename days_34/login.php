<?php
function _retriever($url, $data = NULL, $header = NULL, $method = 'GET')
{
    $cookie_file_path = dirname(__FILE__) . "/cookie/farmrpg.txt";
    $datas['http_code'] = 0;
    if ($url == "")
        return $datas;

    $data_string = '';
    if ($data != NULL) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data_string .= $key . '=' . urlencode($value) . '&';
            }
            $data_string = rtrim($data_string, '&');
        } else {
            $data_string = $data;
        }
    }

    $ch = curl_init();
    if ($header != NULL) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.46 (KHTML, like Gecko) Chrome/44.0.2403.157 Mobile Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    }

    $html = curl_exec($ch);

    if (!curl_errno($ch)) {
        $datas['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($datas['http_code'] == 200) {
            $datas['result'] = $html;
        } else {
            $datas['error'] = "Request returned HTTP code: " . $datas['http_code'];
        }
    } else {
        $datas['error'] = 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $datas;
}

$header = array(
    'origin: https://farmrpg.com',
    'referer: https://farmrpg.com/index.php',
);

$data = array(
    'username' => 'roxyzc',
    'password' => '12345678910'
);
$html = _retriever('https://farmrpg.com/worker.php?go=login', $data, $header, 'POST');

// $html = _retriever('https://farmrpg.com/index.php');
// print_r($html);

print_r(json_encode('berhasil login'));
