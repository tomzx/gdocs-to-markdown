# Google Docs to markdown

[![License](https://poser.pugx.org/tomzx/gdocs-to-markdown/license.svg)](https://packagist.org/packages/tomzx/gdocs-to-markdown)
[![Latest Stable Version](https://poser.pugx.org/tomzx/gdocs-to-markdown/v/stable.svg)](https://packagist.org/packages/tomzx/gdocs-to-markdown)
[![Latest Unstable Version](https://poser.pugx.org/tomzx/gdocs-to-markdown/v/unstable.svg)](https://packagist.org/packages/tomzx/gdocs-to-markdown)
[![Build Status](https://img.shields.io/travis/tomzx/gdocs-to-markdown.svg)](https://travis-ci.org/tomzx/gdocs-to-markdown)
[![Code Quality](https://img.shields.io/scrutinizer/g/tomzx/gdocs-to-markdown.svg)](https://scrutinizer-ci.com/g/tomzx/gdocs-to-markdown/code-structure)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tomzx/gdocs-to-markdown.svg)](https://scrutinizer-ci.com/g/tomzx/gdocs-to-markdown)
[![Total Downloads](https://img.shields.io/packagist/dt/tomzx/gdocs-to-markdown.svg)](https://packagist.org/packages/tomzx/gdocs-to-markdown)

A simple application which lets you export files from a specific folder in Google Drive into markdown.

## Getting started

1. Create a `google-documents-exporter.p12` at the root of the application which can be obtained by following [this guide](https://developers.google.com/api-client-library/php/auth/service-accounts#creatinganaccount).
2. Run `php export.php $random@developer.gserviceaccount.com $folderId`, where `$random@developer.gserviceaccount.com` ìs the service account account which can be obtained through the `Google's Developers Console - Permissions` and `$folderId` is the identifier of the folder you want to convert to markdown. All the documents in subfolders will be converted to markdown as well. You can find the final output in the `output` directory.

## License

The code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). See [LICENSE](LICENSE).
