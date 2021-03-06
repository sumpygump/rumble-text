<?php
/**
 * @package RumbleText
 */

namespace RumbleText;

/**
 * RumbleText
 *
 * @package RumbleText
 * @author Jansen Price <jansen.price@gmail.com>
 */
class RumbleText
{
    const LETTERSET_ORIGINAL = 'original';
    const LETTERSET_EQUAL = 'equal';
    const LETTERSET_BABA = 'baba';
    const LETTERSET_CAESAR = 'caesar';
    const LETTERSET_HAYDEN = 'hayden';
    const LETTERSET_PARSELTONGUE = 'parseltongue';

    public static $lettersets = [
        self::LETTERSET_ORIGINAL,
        self::LETTERSET_EQUAL,
        self::LETTERSET_BABA,
        self::LETTERSET_CAESAR,
        self::LETTERSET_HAYDEN,
        self::LETTERSET_PARSELTONGUE,
    ];

    /**
     * Current letterset
     *
     * @var string
     */
    public $letterset = '';

    /**
     * @var string Vowels
     */
    public $vowels = 'aaaeeeeiioouy';

    /**
     * @var string consonants
     */
    public $consonants = 'bbbccddffghkjlmmmnnnppprrrrsssssttttvwz';

    /**
     * @var string Store top level domains to use for random websites
     */
    public $tlds = ['com', 'net', 'org', 'io', 'edu'];

    /**
     * Constructor
     *
     * @param string $letterset
     * @return void
     */
    public function __construct($letterset = self::LETTERSET_ORIGINAL)
    {
        $this->useLetterset($letterset);
    }

    /**
     * Seed the random generator
     *
     * @param int $input
     * @return self
     */
    public function seed(int $input)
    {
        mt_srand($input);
        return $this;
    }

    /**
     * Use a specific letterset
     *
     * @param mixed $letterset The letter set to use
     * @return void
     */
    public function useLetterset($letterset)
    {
        switch ($letterset) {
        case self::LETTERSET_ORIGINAL:
            $this->vowels     = 'aaaeeeeiioouy';
            $this->consonants = 'bbbccddffghkjlmmmnnnppprrrrsssssttttvwz';
            break;
        case self::LETTERSET_EQUAL:
            // Probability of all vowels and consonants equal
            $this->vowels     = 'aeiou';
            $this->consonants = 'bcdfghjklmnpqrstvwxyz';
            break;
        case self::LETTERSET_PARSELTONGUE:
            // Not a very good approximation of parseltongue
            $this->vowels     = 'aaaaaaiiiiiieu';
            $this->consonants = 'ssssshhhhhtf';
            break;
        case self::LETTERSET_BABA:
            // This letter set picks 1 random vowel and 1 random consonant
            // and those two letters will be used as the letter set
            $vlist = 'aeiou';
            $clist = 'bcdfghjklmnpqrstvwxyz';

            $this->vowels     = $vlist[mt_rand(0, 4)];
            $this->consonants = $clist[mt_rand(0, 20)];
            break;
        case self::LETTERSET_CAESAR:
            // This is based on the frequency that letters occur in the
            // English language (from the man page of caesar)
            $this->vowels = str_repeat('e', 1300)
                .str_repeat('a', 810)
                .str_repeat('o', 790)
                .str_repeat('i', 630)
                .str_repeat('u', 240)
                .str_repeat('y', 95);

            $this->consonants = str_repeat('t', 1050)
                .str_repeat('n', 710)
                .str_repeat('r', 680)
                .str_repeat('s', 610)
                .str_repeat('h', 520)
                .str_repeat('d', 380)
                .str_repeat('l', 340)
                .str_repeat('f', 290)
                .str_repeat('c', 270)
                .str_repeat('m', 250)
                .str_repeat('g', 200)
                .str_repeat('p', 190)
                .str_repeat('y', 95)
                .str_repeat('w', 150)
                .str_repeat('b', 140)
                .str_repeat('v', 90)
                .str_repeat('k', 40)
                .str_repeat('x', 15)
                .str_repeat('j', 13)
                .str_repeat('q', 11)
                .str_repeat('z', 7);

            break;
        case self::LETTERSET_HAYDEN:
            // This is based on a paper of the phoneme count by Rebecca
            // Hayden
            $this->vowels = str_repeat('a', 996 + 309 + 180 + 146)
                .str_repeat('i', 975 + 166)
                .str_repeat('e', 203 + 194 + 102)
                .str_repeat('o', 149)
                .str_repeat('u', 152 + 99)
                .str_repeat('y', 95);

            $this->consonants = array_merge(
                array_fill(0, 795, 'n'),
                array_fill(0, 759, 't'),
                array_fill(0, 710, 'r'),
                array_fill(0, 489, 's'),
                array_fill(0, 365, 'l'),
                array_fill(0, 335, 'th'),
                array_fill(0, 321, 'd'),
                array_fill(0, 298, 'k'),
                array_fill(0, 287, 'm'),
                array_fill(0, 236, 'z'),
                array_fill(0, 233, 'v'),
                array_fill(0, 225, 'p'),
                array_fill(0, 177, 'w'),
                array_fill(0, 165, 'b'),
                array_fill(0, 161, 'f'),
                array_fill(0, 120, 'y'),
                array_fill(0, 114, 'g'),
                array_fill(0, 111, 'h'),
                array_fill(0, 87, 'sh'),
                array_fill(0, 80, 'ng'),
                array_fill(0, 53, 'ch'),
                array_fill(0, 50, 'j'),
                array_fill(0, 44, 'wh'),
                array_fill(0, 44, 'zh')
            );
            break;
        default:
            throw new \Exception("Invalid letterset '$letterset'");
            break;
        }

        $this->letterset = $letterset;

        if (is_string($this->consonants)) {
            $this->consonants = str_split($this->consonants);
        }
    }

    /**
     * Generate a random string
     *
     * By default, an eight character string is returned.
     *
     * @param integer $length Length of the returned string
     * @param string $characters The characters to use
     * @return string
     */
    public function generateRandomString($length = 8, $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_')
    {
        if (!is_int($length)) {
            return '';
        }

        if (is_array($characters) || is_object($characters)) {
            $characters = static::implode_recur('', $characters);
        }

        if (strlen($characters) < 1) {
            return '';
        }

        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    /**
     * Generate a random phrase
     *
     * @param int $min Minimum word count
     * @param int $max Maximum word count
     * @return string
     */
    public function generateRandomPhrase($min = 1, $max = 5, $as_array = false)
    {
        $wordcount = mt_rand($min, $max);

        $words = [];
        for ($i = 0; $i < $wordcount; $i++) {
            $words[] = $this->generateRandomWord(mt_rand(2, 8));
        }

        // First word capitalized
        $words[0] = ucfirst($words[0]);

        if ($as_array) {
            return $words;
        }

        return ucfirst(implode(' ', $words));
    }

    /**
     * Generate a random phrase
     *
     * @param int $min Minimum word count
     * @param int $max Maximum word count
     * @return string
     */
    public function generateRandomSentence($min = 1, $max = 20, $as_array = false)
    {
        $sentence = $this->generateRandomPhrase($min, $max, true);

        // Determine terminator of sentence
        $punctuation = '........!?';
        $selected_punctuation = $punctuation[mt_rand(0, strlen($punctuation) - 1)];
        $last_word = count($sentence) - 1;
        $sentence[$last_word] = $sentence[$last_word] . $selected_punctuation;

        // Insert a comma somewhere in the sentence?
        $should_insert_comma = static::randomChance(0.25);
        if ($should_insert_comma && count($sentence) > 1) {
            $comma = mt_rand(0, count($sentence) - 2);
            $sentence[$comma] = $sentence[$comma] . ",";
        }

        // Put some words in quotes?
        $should_insert_quotes = static::randomChance(0.1);
        if ($should_insert_quotes) {
            $first = mt_rand(0, count($sentence) - 1);
            $last = mt_rand($first, count($sentence) - 1);
            $sentence[$first] = '"' . $sentence[$first];
            $ending = ($last == count($sentence) - 1) ? '"' : ',"';
            $sentence[$last] = $sentence[$last] . $ending;
        }

        if ($as_array) {
            return $sentence;
        }

        return implode(' ', $sentence);
    }

    /**
     * Generate a random paragraph
     *
     * @param int $min Minimum sentence count
     * @param int $max Maximum sentence count
     * @return string
     */
    public function generateRandomParagraph($min = 1, $max = 20, $exact_wordcount = null, $as_array = false)
    {
        $sentencecount = mt_rand($min, $max);
        $min_sentence_words = ($exact_wordcount) ? floor($exact_wordcount / $sentencecount) : 1;
        $max_sentence_words = 20;

        if ($min_sentence_words > $max_sentence_words) {
            $max_sentence_words = floor($min_sentence_words * 1.5);
        }

        $sentences = [];
        for ($i = 0; $i < $sentencecount; $i++) {
            $sentences[] = $this->generateRandomSentence($min_sentence_words, $max_sentence_words, true);
        }

        // Flatten all the words
        $paragraph = [];
        foreach ($sentences as $sentence) {
            foreach ($sentence as $word) {
                $paragraph[] = $word;
            }
        }

        if ($exact_wordcount) {
            // To enforce a specific word count of the paragraph
            $paragraph = array_slice($paragraph, 0, $exact_wordcount);
            $last_word = count($paragraph) - 1;
            $paragraph[$last_word] = $paragraph[$last_word] . ".";
        }

        if ($as_array) {
            return $paragraph;
        }

        return implode(' ', $paragraph);
    }

    /**
     * Generate a set of random paragraphs
     *
     * @param int $min
     * @param int $max
     * @return void
     */
    public function generateRandomArticle($min = 1, $max = 8, $exact_wordcount = null)
    {
        if ($exact_wordcount) {
            // Just keep making paragraphs until we have enough words
            $words = [];
            while (count($words) < $exact_wordcount) {
                $paragraph = $this->generateRandomParagraph(1, 20, null, true);
                $paragraph[] = "\n\n";
                $words = array_merge($words, $paragraph);
            }

            // Trim to match the desired word count
            $words = array_slice($words, 0, $exact_wordcount);
            $last_word = count($words) - 1;
            $last_letter = substr($words[$last_word], -1);
            if ($last_letter == ',') {
                $words[$last_word] = substr($words[$last_word], 0, -2) . ".";
            }
            if ($last_letter != '.' && $last_letter != ',') {
                $words[$last_word] = $words[$last_word] . ".";
            }

            // Gotta replace those newlines next to spaces
            return str_replace("\n ", "\n", trim(implode(' ', $words)));
        }

        $paragraphcount = mt_rand($min, $max);

        $paragraphs = [];
        for ($i = 0; $i < $paragraphcount; $i++) {
            $paragraphs[] = $this->generateRandomParagraph();
        }

        return implode("\n\n", $paragraphs);
    }

    /**
     * Generate a random pronouncable word
     *
     * @param int $length The length of the word
     * @param bool $lower_case Return the word in lowercase
     * @param bool $ucfirst Whether to capitalize the first letter
     * @param bool $upper_case Return the word in uppercase
     * @return string
     */
    public function generateRandomWord($length = 5, $lower_case = true, $ucfirst = false, $upper_case = false, $exactlength = false)
    {
        // Really simple syllable structures
        //$syllable_types = ['CV', 'CVC'];

        // More complex syllable structures
        //$syllable_types = array('V','CV','CV','CV','CV','CVC','CVC','CVVC','CVV');

        // Syllable structures based on the ratio of occurences of the top
        // sensible patterns while analysing an English novel
        $syllable_types = array_merge(
            array_fill(0, 131, 'CVC'),
            array_fill(0, 126, 'VC'),
            array_fill(0, 105, 'CV'),
            array_fill(0, 55, 'CVCV')
        );

        $done = false;
        $word = '';

        while (!$done) {
            $syllable_type = $syllable_types[mt_rand(0, count($syllable_types)-1)];
            $word .= $this->generateSyllable($syllable_type);

            if (strlen($word) >= $length) {
                $done = true;
            }
        }

        // Truncate to exact length
        $word = ($exactlength) ? substr($word, 0, $length) : $word;

        // Make lowercase
        $word = ($lower_case) ? strtolower($word) : $word;

        // Make first letter uppercase
        $word = ($ucfirst) ? ucfirst(strtolower($word)) : $word;

        // Make uppercase
        $word = ($upper_case) ? strtoupper($word) : $word;

        return $word;
    }

    /**
     * generateSyllable
     *
     * @param string $syllable_type The syllable type (a string containing Cs and Vs)
     * @return string
     */
    public function generateSyllable($syllable_type = "CV")
    {
        $out = '';

        $syllable_type = strtoupper($syllable_type);

        $total_consonants = count($this->consonants);
        $total_vowels = strlen($this->vowels);

        for ($i = 0; $i < strlen($syllable_type); $i++) {
            switch ($syllable_type[$i]) {
            case "C":
                $out .= $this->consonants[
                    mt_rand(0, $total_consonants - 1)
                ];
                break;
            case "V":
                $out .= $this->vowels[
                    mt_rand(0, $total_vowels - 1)
                ];
                break;
            }
        }

        return $out;
    }

    /**
     * Generate a random name
     *
     * @param int $maxlength The maximum length of the name
     * @return string
     */
    public function generateRandomName($maxlength = 10)
    {
        if (null == $maxlength) {
            $maxlength = 10;
        }

        $length = mt_rand(1, $maxlength);
        return $this->generateRandomWord($length, false, true, false, true);
    }

    /**
     * Generate a random company name
     *
     * @param int $maxwords The maxiumum number of words in the name
     * @return string
     */
    public function generateRandomCompany($maxwords = 2)
    {
        if (null == $maxwords) {
            $maxwords = 2;
        }

        $suffixes = array('Inc.', 'Enterprises', 'Corporation', 'LLC.');

        $wordcount = mt_rand(1, $maxwords);
        $company = [];

        for ($i = 0; $i < $wordcount; $i++) {
             $company[] = $this->generateRandomName(mt_rand(4, 15));
        }

        $company[] = $suffixes[mt_rand(0, count($suffixes) - 1)];

        return implode(' ', $company);
    }

    /**
     * Generate a random website address
     *
     * @return string
     */
    public function generateRandomWebsite()
    {
        $subdomain = mt_rand(0, 1) ? "www." : "";

        return sprintf("%s%s.%s",
            $subdomain,
            $this->generateRandomWord(mt_rand(3, 15)),
            $this->tlds[mt_rand(0, count($this->tlds) - 1)]
        );
    }

    /**
     * Generate a random email address
     *
     * @return string
     */
    public function generateRandomEmail()
    {
        return sprintf("%s@%s.%s",
            $this->generateRandomWord(mt_rand(2, 10)),
            $this->generateRandomWord(mt_rand(3, 16)),
            $this->tlds[mt_rand(0, count($this->tlds) - 1)]
        );
    }

    /**
     * Generate a random string of digits
     *
     * @param int $minlength The minimum number of digits
     * @param int $maxlength The maximum number of digits
     * @param int $exactlength Generate a number with exactly this many digits
     * @return string
     */
    public function generateRandomDigits($minlength = 4, $maxlength = 16, $exactlength = 0)
    {
        if ($exactlength != 0) {
            $length = $exactlength;
        } else {
            $length = mt_rand($minlength, $maxlength);
        }

        return $this->generateRandomString($length, '1234567890');
    }

    /**
     * Generate a random phone number
     *
     * @return string
     */
    public function generateRandomPhone()
    {
        return sprintf("%s-%s-%s",
            $this->generateRandomDigits(0, 0, 3),
            $this->generateRandomDigits(0, 0, 3),
            $this->generateRandomDigits(0, 0, 4)
        );
    }

    /**
     * Generate a random street address
     *
     * @return string
     */
    public function generateRandomAddress()
    {
        $roads  = ["St.", "Ave.", "Blvd.", "Way", "Rd.", "Parkway", "Place"];
        $length = mt_rand(1, 10);

        return sprintf("%s %s %s",
            $this->generateRandomDigits(2, 5),
            $this->generateRandomWord($length, false, true),
            $roads[mt_rand(0, count($roads) - 1)]
        );
    }

    /**
     * Generate a random chance (bool) based off probability
     *
     * @param float $probability
     * @return bool
     */
    public static function randomChance(float $probability = 0.5)
    {
        $probability = abs($probability);

        // Expected input to be between 0.0 and 1.0
        // If it is out of that range, tone it down
        while ($probability > 1) {
            $probability = $probability / 10;
        }

        // Scale up to make an array that fits the probability
        $scale = 10;
        $scaled_prob = $probability * $scale;
        while (fmod($scaled_prob, 1) > 0 && $scale < 10000) {
            $scale = $scale * 10;
            $scaled_prob = $probability * $scale;
        }

        $opts_false = array_fill(0, $scale - $scaled_prob, false);
        $opts_true = array_fill(0, $scaled_prob, true);

        $opts = array_merge($opts_false, $opts_true);

        return $opts[mt_rand(0, count($opts) - 1)];
    }

    /**
     * Utility function to convert a nested array to a string
     *
     * @param mixed $glue
     * @param mixed $input
     * @return void
     */
    public static function implode_recur($glue, $input)
    {
        $out = [];

        if (is_object($input)) {
            $input = (array) $input;
        }

        if (is_iterable($input)) {
            foreach ($input as $item) {
                if (is_array($item) || is_object($item)) {
                    $out[] = self::implode_recur($glue, $item);
                } else {
                    $out[] = $item;
                }
            }
        } else {
            $out[] = $input;
        }

        return implode($glue, $out);
    }
}
