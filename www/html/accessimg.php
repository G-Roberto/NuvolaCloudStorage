<?php include "../inc/creds.inc"; ?>
<?php
	require '/usr/local/bin/vendor/autoload.php'; // Include the SDK using Composer

	use Aws\S3\S3Client;
	use Aws\Exception\AwsException;

	// Set up the S3 client
	$client = new S3Client([
		'version' => 'latest',
		'region' => 'eu-central-1', // Replace with the appropriate region
		'credentials' => [
			'key' => KKEY,
			'secret' => SSECRET,
		],
	]);

	// Set the bucket name and object key	
	$bucket = 'sam-app-s3uploadbucket-1ut0y5lkfg694';
	$key = explode("?", $_SERVER['REQUEST_URI'])[1];

	// Check if the access key and secret key have access to the bucket
	try {
		$client->headBucket(['Bucket' => $bucket]);
	} catch (AwsException $e) {
		echo "Error: " . $e->getMessage();
		exit();
	}

	// Generate a presigned URL with a 1-minute expiration time
	$cmd = $client->getCommand('GetObject', [
		'Bucket' => $bucket,
		'Key' => $key,
	]);
	$request = $client->createPresignedRequest($cmd, '+1 minute');
	$presignedUrl = (string) $request->getUri();

	// Output the presigned URL
	
	echo $presignedUrl;
	header('Location: '.$presignedUrl);
?>