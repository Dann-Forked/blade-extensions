<?php
/**
 * Markdown transformer Helpers
 */
namespace Radic\BladeExtensions\Helpers;

use Caffeinated\Beverage\Str;

/**
 * Markdown transformer Helpers
 *
 * @package                 Radic\BladeExtensions
 * @subpackage              Helpers
 * @version                 2.1.0
 * @author                  Robin Radic
 * @license                 MIT License - http://radic.mit-license.org
 * @copyright               2011-2015, Robin Radic
 * @link                    http://robin.radic.nl/blade-extensions
 *
 */
class Markdown
{
    /**
     * Removes indentation
     * @param string $text The markdown text
     * @return mixed
     */
    protected static function transform($text)
    {
        $firstLine = explode("\n", $text, 1);
        $firstLine = Str::toSpaces($firstLine[0], 4);
        preg_match('/([\s]*).*/', $firstLine, $firstLineSpacesMatches);

        if (isset($firstLineSpacesMatches[1])) {
            $spaceMatcher = "";
            for ($i = 0; $i < strlen($firstLineSpacesMatches[1]); $i++) {
                $spaceMatcher .= "\s";
            }
            $spaceMatcher = '/^' . $spaceMatcher . '(.*)/m';
            $newText      = preg_replace($spaceMatcher, '$1', $text);

            return $newText;
        }

        return $text;
    }

    /**
     * Parses markdown text into html
     * @param string $text the markdown text
     * @return string $newText html
     */
    public static function parse($text)
    {
        $text = static::transform($text);
        $newText = app()->make('markdown')->render($text);
        return $newText;
    }
}
