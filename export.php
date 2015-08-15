<?php

use tomzx\GoogleDocsToMarkdown\Exporter;

require 'vendor/autoload.php';

define('SCOPES', implode(' ', [
	Google_Service_Drive::DRIVE_READONLY,
]));

/**
 * Returns an authorized API client.
 *
 * @param string $email
 * @return \Google_Client the authorized client object
 */
function getClient($email)
{
	$privateKey = file_get_contents('google-documents-exporter.p12');
	$credentials = new Google_Auth_AssertionCredentials($email, SCOPES, $privateKey);

	$client = new Google_Client();
	$client->setAssertionCredentials($credentials);
	if ($client->getAuth()->isAccessTokenExpired()) {
		$client->getAuth()->refreshTokenWithAssertion();
	}

	return $client;
}

// Get the API client and construct the service object.
$client = getClient($argv[1]);

$exporter = new Exporter($client);
$exporter->export($argv[2], 'output');
