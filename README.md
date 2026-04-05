 MetaDescriptionTag MediaWiki extension
=======================================

This is very simple MediaWiki extension for adding a
`<meta>` description tag to the page's `<head>`.


The original author is Joshua C. Lerner, based on an (unavailable) tutorial by Jim R. Wilson.
Since version 0.3.0 it is maintained by Dror S. [FFS].


## Requirements
Version >= 0.5.0 requires MediaWiki 1.43+.

## Configuration
This extension has no configuration options.

## Usage
You can use MetaDescriptionTag by adding the <metadesc> tag to articles: 
`<metadesc>Home page for the MetaDescriptionTag MediaWiki extension</metadesc>`

For use in templates, you can call it using `{{#tag:metadesc}}`, for example: 
`{{#tag:metadesc | A description - {{{1}}} }}`.


## Changelog

### 0.5.0
Modernize for MediaWiki 1.43+: service injection, namespaced hooks
- AutoloadClasses -> AutoloadNamespaces
- Modern HookHandlers
- Namespace the extension
- Add unit tests                               

### 0.4.0
This is re-write to make it compatible with more modern MediaWiki practices and make sure it
works nicely with MediaWiki 1.27+:
- Extension Registration (extension.json)
- json i18n files
- An actual README file! :-)
- Switching to semantic versioning.

### 0.3
Fix i18n to work with v1.16+, sanitize output using htmlspecialchars().

### 0.2
Change syntax to <metadesc>some content</metadesc> to support template variable substitution.

### 0.1
Initial release.
 
