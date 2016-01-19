<?php

namespace tomzx\GoogleDocsToMarkdown;

use League\HTMLToMarkdown\HtmlConverter;
use tomzx\GoogleDocsToMarkdown\HtmlConverter\EmphasisConverter;

class Converter {
	/**
	 * @var \League\HTMLToMarkdown\HtmlConverter
	 */
	protected $converter;

	public function __construct()
	{
		$this->converter = new HtmlConverter([
			'header_style' => 'atx',
			'strip_tags' => true,
			'remove_nodes' => 'head',
		]);
	}

	/**
	 * @return \League\HTMLToMarkdown\HtmlConverter
	 */
	public function getConverter()
	{
		return $this->converter;
	}

	/**
	 * @param string $html
	 * @return string
     */
	public function convert($html)
	{
		$markdown = $this->converter->convert($html);
		return $this->processMarkdown($markdown);
	}

	/**
	 * @param string $markdown
	 * @return string
     */
	protected function processMarkdown($markdown)
	{
		// Remove Google link tracking
		$markdown = preg_replace_callback('/\(https?:\/\/www\.google\.com\/url\?q=(?<url>[^&]+)[^\)]+\)/', function ($matches) {
			return '('.urldecode($matches['url']).')';
		}, $markdown);
		return $markdown;
	}
}
