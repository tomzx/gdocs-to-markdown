<?php

namespace tomzx\GoogleDocsToMarkdown;

use Google_Client;
use Google_Service_Drive;
use League\HTMLToMarkdown\HtmlConverter;

class Exporter {
	/**
	 * @var \Google_Client
	 */
	protected $client;

	public function __construct(Google_Client $client)
	{
		$this->client = $client;
	}

	public function export($folderId, $targetDirectory)
	{
		$service = new Google_Service_Drive($this->client);

		$converter = new HtmlConverter([
			'header_style' => 'atx',
			'strip_tags' => true,
			'remove_nodes' => 'head',
		]);

		if ( ! file_exists($targetDirectory)) {
			mkdir($targetDirectory);
		}

		$parameters = [
			'q' => 'mimeType="application/vnd.google-apps.document"',
		];

		$children = $service->children->listChildren($folderId, $parameters);

		foreach ($children->getItems() as $child) {
			$fileId = $child->getId();
			$file = $service->files->get($fileId);
			$title = $file->getTitle();

			echo 'Downloading '.$title . PHP_EOL;

			$downloadUrl = $file->getExportLinks()['text/html'];
			$content = file_get_contents($downloadUrl);

			$markdown = $converter->convert($content);

			$filename = $title.'.md';
			file_put_contents($targetDirectory.'/'.$filename, $markdown);
		}
	}
}
