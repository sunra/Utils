<?php

    namespace Sunra\Utils\Text;

    class Keywords
    {
        static public function getKeywords($text, $defaultKeywords = '')
        {
            $wordCounter = new WordCounter();

            $keywords = $wordCounter->get_keywords($text, $defaultKeywords);

            return $keywords;
        }
    }


