<?php
require_once("aws.phar");

use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Aws\S3\Exception\S3Exception;
use Guzzle\Http\EntityBody;

$client = S3Client::factory(array(
  "key" => "xxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "secret" => "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "region" => Region::AP_NORTHEAST_1 // AP_NORTHEAST_1はtokyo region
));


$tmpfile = $_FILES["upfile"]["tmp_name"];

if (!is_uploaded_file($tmpfile)) {
    die('ファイルがアップロードされていません');
}

// バケット名
$bucket = "s3php";
// アップロードファイル名
$key = "test2.jpg";

try {
    $result = $client->putObject(array(
        'Bucket' => $bucket,
        'Key' => $key,
        'Body' => EntityBody::factory(fopen($tmpfile, 'r')),
    ));
    echo "アップロード成功！";
} catch (S3Exception $exc) {
    echo "アップロード失敗";
    echo $exc->getMessage();
}
?>
