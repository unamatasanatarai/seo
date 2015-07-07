<?php

class SeoMeta
{
    static $title       = array();
    static $description = '';
    static $keywords    = array();
    static $metatags    = array();

    static $separator = ' / ';

    static public function addTitle($title)
    {
        self::$title[] = trim($title);
    }

    static public function setDescription($description)
    {
        $description = strip_tags($description);

        if (mb_strlen($description) > 160) {
            $description = mb_substr($description, 0, 160);
        }

        self::$description = $description;
    }

    static public function addKeyword($keyword)
    {
        if (!is_array($keyword)){
            $keyword = explode(',', $keyword);
        }

        foreach($keyword as $word){
            self::$keywords[] = trim($word);
        }
    }

    // SEOMeta::addMeta('article:section', $post->category, 'property');
    static public function addMeta($meta, $value = null, $name = 'name')
    {
        if (is_array($meta)){
            foreach ($meta as $key => $value){
                self::$metatags[$key] = array($name, $value);
            }
        }else{
            self::$metatags[$meta] = array($name, $value);
        }
    }

    static public function getTitle()
    {
        $title = array_reverse(self::$title);
        return '<title>' . implode(self::$separator, $title) . '</title>';
    }

    static public function getKeywords()
    {
        return '<meta name=keywords content="' . implode(',', array_unique(self::$keywords)) . '">';
    }

    static public function getDescription()
    {
        return '<meta name=description itemprop=description content="' . self::$description . '">';
    }

    static public function getMeta()
    {
        $html = array();
        foreach (self::$metatags as $key => $value){
            $html[]  = '<meta ' . $value[0] . '=' . $key . ' content="' . $value[1] . '">';
        }
        return implode(PHP_EOL, $html);
    }
}
