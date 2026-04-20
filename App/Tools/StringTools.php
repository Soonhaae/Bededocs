<?php

// pour toutes les fonctions de manipulation de chaînes de caractères (ex : pour faire du slugify, etc.)

namespace App\Tools;

// nb : souvent les classes outils sont STATIC (car on n'a pas besoin d'instancier, on appelle juste les fonctions)

class Stringtools {


    public static function toCamelcase($value, $pascalCase = false) {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        $value = str_replace(' ', '', $value);
        if ($pascalCase === false) {
            return lcfirst($value); // transforme la 1re lettre en majuscule (ou pas)
        } else {
            return $value;
        }
    }
    public static function toPascalCase($value) {
        return self::toCamelcase($value, true);
    }
    
    
    
    /* suggestion copilot :

        $value = str_replace(['-', '_'], ' ', $value); // remplacer les tirets et les underscores par des espaces
        $value = ucwords($value); // mettre la première lettre de chaque mot en majuscule
        $value = str_replace(' ', '', $value); // supprimer les espaces
        if (!$pascalCase) {
            $value = lcfirst($value); // mettre la première lettre en minuscule si pas en PascalCase
        }
        return $value;
        
        */


}





/*
pourquoi retirer les - ou _ ?
car dans la BDD, par exemple j'ai une colonne "type_id"
or dans les set je vai avoir un setTypeId()
donc la fonction remplace les - et les _ pour être tranquille avec ça

*/










/* exemples d'autres fonctions qu'on pourrait mettre dans cette classe StringTools :


    public static function slugify($string) {
        // on remplace les espaces par des tirets
        $slug = str_replace(' ', '-', $string);
        // on met tout en minuscules
        $slug = strtolower($slug);
        // on supprime les caractères spéciaux (tout ce qui n'est pas une lettre, un chiffre ou un tiret)
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        // on retourne le slug
        return $slug;
    }

    public static function truncate($string, $length = 100) {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        } else {
            return $string;
        }
    }

    public static function capitalize($string) {
        return ucfirst($string);
    }

    public static function lowercase($string) {
        return strtolower($string);
    }

    public static function uppercase($string) {
        return strtoupper($string);
    }

    public static function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function startsWith($string, $startString) {
        return strncmp($string, $startString, strlen($startString)) === 0;
    }

    public static function endsWith($string, $endString) {
        return substr($string, -strlen($endString)) === $endString;
    }

    public static function contains($string, $substring) {
        return strpos($string, $substring) !== false;
    }

    public static function replace($string, $search, $replace) {
        return str_replace($search, $replace, $string);
    }

    public static function getExcerpt($string, $length = 100) {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        } else {
            return $string;
        }
    }

    public static function getExcerptBySentence($string, $length = 100) {
        $sentences = explode('.', $string);
        $excerpt = '';
        foreach ($sentences as $sentence) {
            if (strlen($excerpt) + strlen($sentence) <= $length) {
                $excerpt .= $sentence . '.';
            } else {
                break;
            }
        }
        return $excerpt;
    }

    public static function getExcerptByParagraph($string, $length = 100) {
        $paragraphs = explode("\n", $string);
        $excerpt = '';
        foreach ($paragraphs as $paragraph) {
            if (strlen($excerpt) + strlen($paragraph) <= $length) {
                $excerpt .= $paragraph . "\n";
            } else {
                break;
            }
        }
        return $excerpt;
    }

    public static function getExcerptByWord($string, $length = 100) {
        $words = explode(' ', $string);
        $excerpt = '';
        foreach ($words as $word) {
            if (strlen($excerpt) + strlen($word) <= $length) {
                $excerpt .= $word . ' ';
            } else {
                break;
            }
        }
        return trim($excerpt) . '...';
    }

    public static function getExcerptByCharacter($string, $length = 100) {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        } else {
            return $string;
        }
    }

    public static function getExcerptByCustom($string, $length = 100, $separator = ' ') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $separator;
            } else {
                break;
            }
        }
        return trim($excerpt) . '...';
    }

    public static function getExcerptByCustomWithSuffix($string, $length = 100, $separator = ' ', $suffix = '...') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $separator;
            } else {
                break;
            }
        }
        return trim($excerpt) . $suffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefix($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $separator;
            } else {
                break;
            }
        }
        return $prefix . trim($excerpt) . $suffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparator($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $prefix . trim($excerpt) . $suffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffix($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $prefix . trim($excerpt) . $customSuffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffixAndCustomPrefix($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...', $customPrefix = '') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $length) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $customPrefix . trim($excerpt) . $customSuffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffixAndCustomPrefixAndCustomLength($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...', $customPrefix = '', $customLength = 100) {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $customLength) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $customPrefix . trim($excerpt) . $customSuffix;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffixAndCustomPrefixAndCustomLengthAndCustomSuffix($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...', $customPrefix = '', $customLength = 100, $customSuffix2 = '...') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $customLength) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $customPrefix . trim($excerpt) . $customSuffix2;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffixAndCustomPrefixAndCustomLengthAndCustomSuffixAndCustomPrefix($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...', $customPrefix = '', $customLength = 100, $customSuffix2 = '...', $customPrefix2 = '') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $customLength) {
                $excerpt .= $part . $customSeparator;
            } else {
                break;
            }
        }
        return $customPrefix2 . trim($excerpt) . $customSuffix2;
    }

    public static function getExcerptByCustomWithSuffixAndPrefixAndCustomSeparatorAndCustomSuffixAndCustomPrefixAndCustomLengthAndCustomSuffixAndCustomPrefixAndCustomSeparator($string, $length = 100, $separator = ' ', $suffix = '...', $prefix = '', $customSeparator = ' ', $customSuffix = '...', $customPrefix = '', $customLength = 100, $customSuffix2 = '...', $customPrefix2 = '', $customSeparator2 = ' ') {
        $parts = explode($separator, $string);
        $excerpt = '';
        foreach ($parts as $part) {
            if (strlen($excerpt) + strlen($part) <= $customLength) {
                $excerpt .= $part . $customSeparator2;
            } else {
                break;
            }
        }
        return $customPrefix2 . trim($excerpt) . $customSuffix2;
    }

*/

