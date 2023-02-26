<?php
/**
 * Markdown Template
 *
 * @link      https://guides.github.com/features/mastering-markdown/
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   DigitalJoeCo\Leantime\Documentor
 */

namespace DigitalJoeCo\Leantime\Documentor;

if ( ! isset( $documentor ) ) {
	return;
}

$actions = $documentor->get_actions();
$filters = $documentor->get_filters();

$eol = "\n";

echo '# Hooks', $eol;

echo $eol;

echo '- [Actions](#actions)', $eol;
echo '- [Filters](#filters)', $eol;

echo $eol;

echo '## Actions', $eol;

echo $eol;

if ( empty( $actions ) ) {
	echo '*This project does not contain any Leantime events.*', $eol;
	echo $eol;
} else {
	foreach ( $actions as $hook ) {
		include __DIR__ . '/parts/markdown-hook.php';
	}
}

echo '## Filters', $eol;

echo $eol;

if ( empty( $filters ) ) {
	echo '*This project does not contain any Leantime filters.*', $eol;
	echo $eol;
} else {
	foreach ( $filters as $hook ) {
		include __DIR__ . '/parts/markdown-hook.php';
	}
}

echo $eol;
