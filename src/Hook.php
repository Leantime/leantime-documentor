<?php
/**
 * Hook
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   DigitalJoeCo\Leantime\Documentor
 */

namespace DigitalJoeCo\Leantime\Documentor;

use Symfony\Component\Finder\SplFileInfo;

/**
 * Hook
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Hook {
	/**
	 * File.
	 *
	 * @link https://symfony.com/doc/current/components/finder.html
	 * @var SplFileInfo
	 */
	private $file;

	/**
	 * Function call.
	 *
	 * @link https://github.com/nikic/PHP-Parser/blob/v4.10.4/lib/PhpParser/Node/Expr/FuncCall.php
	 * @var \PhpParser\Node\Expr\FuncCall
	 */
	private $call;

	/**
	 * Tag.
	 *
	 * @var string
	 */
	private $tag;

	/**
	 * Arguments.
	 *
	 * @var Argument[]
	 */
	public $arguments;

	/**
	 * Doc comment.
	 *
	 * @link https://github.com/nikic/PHP-Parser/blob/v4.10.4/lib/PhpParser/Comment/Doc.php
	 * @link https://github.com/nikic/PHP-Parser/blob/v4.10.4/lib/PhpParser/Comment.php
	 * @var \PhpParser\Comment\Doc|null
	 */
	private $doc_comment;

	/**
	 * Doc block.
	 *
	 * @link https://github.com/phpDocumentor/ReflectionDocBlock/blob/5.2.2/src/DocBlock.php
	 * @var \phpDocumentor\Reflection\DocBlock|null
	 */
	private $doc_block;

	/**
	 * Changelog.
	 *
	 * @var Changelog|null
	 */
	private $changelog;

    public $parent;

	/**
	 * Construct hook.
	 *
	 * @param SplFileInfo                   $file      File.
	 * @param \PhpParser\Node\Expr\FuncCall $call      Function call.
	 * @param Tag                           $tag       Tag.
	 * @param Argument[]                    $arguments Arguments.
	 */
	public function __construct( $file, $call, $tag, $arguments = array() ) {
		$this->file      = $file;
		$this->call      = $call;
		$this->tag       = $tag;
		$this->arguments = $arguments;
	}

	/**
	 * Get file.
	 *
	 * @return SplFileInfo
	 */
	public function get_file() {
		return $this->file;
	}

	/**
	 * Get call.
	 *
	 * @return \PhpParser\Node\Expr\FuncCall
	 */
	public function get_call() {
		return $this->call;
	}

	/**
	 * Get tag.
	 *
	 * @return Tag
	 */
	public function get_tag() {
		return $this->tag;
	}

	/**
	 * Get doc comment.
	 *
	 * @return \PhpParser\Comment\Doc|null
	 */
	public function get_doc_comment() {
		return $this->doc_comment;
	}

	/**
	 * Set doc comment.
	 *
	 * @param \PhpParser\Comment\Doc|null $doc_comment Doc comment.
	 */
	public function set_doc_comment( \PhpParser\Comment\Doc $doc_comment = null ) {
		$this->doc_comment = $doc_comment;
	}

	/**
	 * Get doc block.
	 *
	 * @return \phpDocumentor\Reflection\DocBlock|null
	 */
	public function get_doc_block() {
		return $this->doc_block;
	}

	/**
	 * Set doc block.
	 *
	 * @param \phpDocumentor\Reflection\DocBlock|null $doc_block Doc block.
	 * @return void
	 */
	public function set_doc_block( $doc_block ) {
		$this->doc_block = $doc_block;
	}

	/**
	 * Get start line.
	 *
	 * @return int
	 */
	public function get_start_line() {
		if ( null === $this->doc_comment ) {
			return $this->call->getStartLine();
		}

		return \min( $this->doc_comment->getStartLine(), $this->call->getStartLine() );
	}

	/**
	 * Get end line.
	 *
	 * @return int
	 */
	public function get_end_line() {
		return $this->call->getEndLine();
	}

	/**
	 * Get summary.
	 *
	 * @return string|null
	 */
	public function get_summary() {
		if ( null === $this->doc_block ) {
			return null;
		}

		return $this->doc_block->getSummary();
	}

	/**
	 * Get description.
	 *
	 * @return string|null
	 */
	public function get_description() {
		if ( null === $this->doc_block ) {
			return null;
		}

		return $this->doc_block->getDescription()->getBodyTemplate();
	}

	/**
	 * Is filter.
	 *
	 * @return bool True if is filter, false otherwise.
	 */
	public function is_filter() {
		return \in_array(
			\strval( $this->call->name ),
			array(
				'dispatch_filter',
                'dispatchTplFilter',
                'dispatchMailerFilter',
				'dispatchFilter'
			),
			true
		);
	}

	/**
	 * Is action.
	 *
	 * @return bool True if is action, false otherwise.
	 */
	public function is_action() {
		return \in_array(
			\strval( $this->call->name ),
			array(
				'dispatch_event',
                'dispatchTplEvent',
                'dispatchMailerFilter',
				'dispatchEvent',
				'dispatch'
			),
			true
		);
	}

	/**
	 * Is deprecated.
	 *
	 * @return bool True if is deprecated, false otherwise.
	 */
	public function is_deprecated() {
		return \in_array(
			\strval( $this->call->name ),
			array(
				'dispatch_event_deprecated',
				'dispatch_filter_deprecated',
                'dispatchTplEventDeprecated',
                'dispatchTplFilterDeprecated',
                'dispatchMailerEventDeprecated',
                'dispatchMailerFilterDeprecated'
			),
			true
		);
	}

	/**
	 * Tag.
	 *
	 * @return string
	 */
	public function tag() {
		return $this->tag;
	}

	/**
	 * Arguments.
	 *
	 * @return array
	 */
	public function get_arguments() {
		return $this->arguments;
	}

	/**
	 * Changelog.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/activated_plugin/#changelog
	 * @link https://github.com/phpDocumentor/ReflectionDocBlock/blob/5.2.2/src/DocBlock/Tags/Since.php
	 *
	 * @return Changelog|null
	 */
	public function get_changelog() {
		return $this->changelog;
	}

	/**
	 * Set changelog.
	 *
	 * @param Changelog|null $changelog Changelog.
	 */
	public function set_changelog( Changelog $changelog = null ) {
		$this->changelog = $changelog;
	}

	/**
	 * Get since.
	 *
	 * @return Since|null
	 */
	public function get_since() {
		if ( null === $this->changelog ) {
			return null;
		}

		return $this->changelog->get_first();
	}

	/**
	 * Get since version.
	 *
	 * @return string|null
	 */
	public function get_since_version() {
		$since = $this->get_since();

		if ( null === $since ) {
			return null;
		}

		return $since->get_version();
	}

    public function get_hook(): string
    {
        $parts = explode('/', $this->file);
        $parts = array_map(
            function ($part) {
                if (str_contains($part, 'class.')) {
                    $part = str_replace('class.', '', $part);
                }

                if (str_contains($part, '.php')) {
                    $part = str_replace('.php', '', $part);
                }

                return $part;
            },
            $parts
        );
        if (($key = array_search('app', $parts)) !== false) {
            unset($parts[$key]);
        }
        $hook_context = implode('.', $parts);

        /** Because of reflection, there are specific hooks for each controller */
        if ($hook_context == 'core.controller') {
            $hook_context = 'domain.{$module}.controllers.{$controller}';
        }

        $specific_hook = $this->tag->get_hook();

        /** Because of reflection, there are specific hooks for each db call */
        if ($hook_context == 'core.repository') {
            $hook_context = 'domain.{$module}.repositories.{$repo}';

            $parts = explode('.', $specific_hook);
            $specific_hook = '{$method}.' . $parts[1];
        }

        return "$hook_context.$specific_hook";
    }
}
