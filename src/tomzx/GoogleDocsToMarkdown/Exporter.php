<?php

namespace tomzx\GoogleDocsToMarkdown;

use Google_Client;
use Google_Service_Drive;

class Exporter {
	/**
	 * @var \Google_Client
	 */
	protected $client;
	/**
	 * @var \Google_Service_Drive
	 */
	protected $service;
	/**
	 * @var \tomzx\GoogleDocsToMarkdown\Converter
	 */
	protected $converter;

	/**
	 * @param \Google_Client $client
	 */
	public function __construct(Google_Client $client)
	{
		$this->client = $client;
		$this->service = new Google_Service_Drive($this->client);
		$this->converter = new Converter();
	}

	/**
	 * @param string $folderId
	 * @param $outputDirectory
	 * @param string $path
	 */
	public function export($folderId, $outputDirectory, $path = null)
	{
		$this->exportFiles($folderId, $outputDirectory, $path);

		$this->exportFolders($folderId, $outputDirectory, $path);
	}

	/**
	 * @param string $folderId
	 * @param $outputDirectory
	 * @param string $path
	 * @return array
	 */
	protected function exportFiles($folderId, $outputDirectory, $path)
	{
		$targetDirectory = $outputDirectory . '/' . $path;
		if ( ! file_exists($targetDirectory)) {
			mkdir($targetDirectory, 0777, true);
		}

		$parameters = [
			'q' => 'mimeType="application/vnd.google-apps.document"',
		];

		$children = $this->service->children->listChildren($folderId, $parameters);
		foreach ($children->getItems() as $child) {
			$fileId = $child->getId();
			$file = $this->service->files->get($fileId);
			$title = $file->getTitle();
			$targetPath = $path ? $path . '/' . $title : $title;

			echo 'Downloading ' . $targetPath . ' ... ';

			$downloadUrl = $file->getExportLinks()['text/html'];
			$content = file_get_contents($downloadUrl);

			echo 'Converting ... ';

			$markdown = $this->converter->convert($content);

			$filename = $title . '.md';
			file_put_contents($targetDirectory . '/' . $filename, $markdown);

			echo 'Done!' . PHP_EOL;
		}
	}

	/**
	 * @param string $folderId
	 * @param $outputDirectory
	 * @param string $path
	 */
	protected function exportFolders($folderId, $outputDirectory, $path)
	{
		$parameters = [
			'q' => 'mimeType="application/vnd.google-apps.folder"',
		];

		$children = $this->service->children->listChildren($folderId, $parameters);
		foreach ($children->getItems() as $child) {
			$folderId = $child->getId();
			$folder = $this->service->files->get($folderId);
			$title = $folder->getTitle();

			$path = $path ? $path . '/' . $title : $title;
			$this->export($folderId, $outputDirectory, $path);
		}
	}
}
