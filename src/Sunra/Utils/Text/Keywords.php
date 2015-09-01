<?php

    namespace Sunra\Utils\Text;

    use \Sunra\HtmlToText;

    class Keywords
    {
        static public function getKeywords($text, $defaultKeywords = '')
        {
            $wordCounter = new WordCounter();
//\Sunra\HtmlToText\HtmlToText::/*plain_text*/filter( $topic_text, 'br,b,p,i' );
            $keywords = $wordCounter->get_keywords($text, $defaultKeywords);

            return $keywords;
        }
    }


