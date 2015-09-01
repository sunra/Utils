<?php
    namespace Utils\Text;

    class WordCounter
    {
        var $origin_arr;
        var $modif_arr;
        var $min_word_length = 5;

        function explode_str_on_words($text)
        {

            $search = array ("'/bitrix/[^\s]+\s'",
                "'ё'",
                "'<script[^>]*?>.*?</script>'si",  // Вырезается javascript
                "'<[\/\!]*?[^<>]*?>'si",           // Вырезаются html-тэги
                "'([\r\n])[\s]+'",                 // Вырезается пустое пространство
                "'&(quot|#34);'i",                 // Замещаются html-элементы
                "'&(amp|#38);'i",
                "'&(lt|#60);'i",
                "'&(gt|#62);'i",
                "'&(nbsp|#160);'i",
                "'&(iexcl|#161);'i",
                "'&(cent|#162);'i",
                "'&(pound|#163);'i",
                "'&(copy|#169);'i",
                "'&#(\d+);'e"
            );

            $replace = array (" ",
                "е",
                " ",
                " ",
                "\\1 ",
                "\" ",
                " ",
                " ",
                " ",
                " ",
                chr(161),
                chr(162),
                chr(163),
                chr(169),
                "chr(\\1)"
            );

//$text = preg_replace ($search, $replace, $text);
//echo $text;

            $del_symbols = array(",", ".", ";", ":", "\"", "#", "\$", "%", "^",
                "!", "@", "`", "~", "*", "-", "=", "+", "\\",
                "|", "/", ">", "<", "(", ")", "&", "?", "№", "\t",
                "\r", "\n", "{","}","[","]", "'", "“", "”", "•","»","«",
                "ndash","nbsp",
                "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                "laquo", "raquo"
            );

            $text = str_replace($del_symbols, " ", $text);


            $text = ereg_replace("( +)", " ", $text);
            $this->origin_arr = explode(" ", trim($text));

            // Удалить несмысловые слова

            $ar_dop = array(
                "как", "для", "что", "или", "это", "этих",
                "він", "від", "його", "чорт", "квм", "мкв",
                "всех", "вас", "они", "оно", "еще", "когда",
                "где", "эта", "лишь", "уже", "вам", "нет",
                "если", "надо", "все", "так", "его", "чем",
                "при", "даже", "мне", "есть", "раз", "два","например","будет",
                "через", "более", "является", "который", "быстрее", "можно"
            );

            $this->origin_arr = array_diff	($this->origin_arr, $ar_dop);

            return $this->origin_arr;
        }

        function count_words()
        {
            $tmp_arr = array();
            foreach ($this->origin_arr as $val)
            {
                if (strlen($val)>=$this->min_word_length)
                {
                    $val = strtolower($val);
                    if (array_key_exists($val, $tmp_arr))
                    {
                        $tmp_arr[$val]++;
                    }
                    else
                    {
                        $tmp_arr[$val] = 1;
                    }
                }
            }
            arsort ($tmp_arr);
            $this->modif_arr = $tmp_arr;
        }

        function get_keywords($text, $arr_predefined = array())
        {
            $this->explode_str_on_words($text);
            $this->count_words();
            $arr = array_slice($this->modif_arr, 0, 15);

            $arr_ = array();
            foreach ($arr as $key=>$val)
            {
                if (trim ($key) <> '') $arr_[] = $key;
            }

            $arr_ = array_diff($arr_, $arr_predefined);
            $arr_ = array_merge($arr_predefined, $arr_);

            foreach ($arr_ as $cur) {
                if (trim ($cur) <> '') $arr__[] = $cur;
            }
            $arr_ = array_unique ($arr__);

            return strtolower(implode(',',$arr_));

        }
    }