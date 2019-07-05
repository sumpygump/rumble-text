<?php

use PHPUnit\Framework\TestCase;

use RumbleText\RumbleText;

final class RumbleTextTest extends TestCase
{
    public function testConstruct()
    {
        $provider = new RumbleText();
        $this->assertInstanceOf(RumbleText::class, $provider);
        $this->assertEquals(RumbleText::LETTERSET_ORIGINAL, $provider->letterset);
        $this->assertEquals('aaaeeeeiioouy', $provider->vowels);
    }

    public function testConstructLettersetEqual()
    {
        $provider = new RumbleText('equal');
        $this->assertEquals(RumbleText::LETTERSET_EQUAL, $provider->letterset);
        $this->assertEquals('aeiou', $provider->vowels);
    }

    public function testConstructLettersetBaba()
    {
        $provider = new RumbleText(RumbleText::LETTERSET_BABA);
        $this->assertEquals(RumbleText::LETTERSET_BABA, $provider->letterset);
        $this->assertSame(1, strlen($provider->vowels));
        $this->assertSame(1, count($provider->consonants));
    }

    public function testConstructLettersetCaesar()
    {
        $provider = new RumbleText(RumbleText::LETTERSET_CAESAR);
        $this->assertEquals(RumbleText::LETTERSET_CAESAR, $provider->letterset);
        $this->assertGreaterThan(2000, strlen($provider->vowels));
    }

    public function testConstructLettersetHayden()
    {
        $provider = new RumbleText(RumbleText::LETTERSET_HAYDEN);
        $this->assertEquals(RumbleText::LETTERSET_HAYDEN, $provider->letterset);
        $this->assertGreaterThan(2000, strlen($provider->vowels));
    }

    public function testConstructLettersetParseltongue()
    {
        $provider = new RumbleText(RumbleText::LETTERSET_PARSELTONGUE);
        $this->assertEquals(RumbleText::LETTERSET_PARSELTONGUE, $provider->letterset);
        $this->assertEquals('aaaaaaiiiiiieu', $provider->vowels);
    }

    public function testConstructInvalidLetterset()
    {
        $this->expectException(\Exception::class);
        $provider = new RumbleText('foobar');
    }

    public function testGenerateRandomString()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString();
        $this->assertEquals(8, strlen($result));
    }

    public function testGenerateRandomStringInvalidLength()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString('');
        $this->assertEquals('', $result);

        $result = $provider->generateRandomString(1.1);
        $this->assertEquals('', $result);

        $wat = new \StdClass();
        $result = $provider->generateRandomString($wat);
        $this->assertEquals('', $result);
    }

    public function testGenerateRandomStringWithEmptyString()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(8, '');
        $this->assertEquals('', $result);
    }

    public function testGenerateRandomStringWithEmptyArray()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(8, []);
        $this->assertEquals('', $result);
    }

    public function testGenerateRandomStringWithArray()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(8, ['x', 'y', 'z']);
        $this->assertEquals(8, strlen($result));

        $result = $provider->generateRandomString(8, [6, 73, 800]);
        $this->assertEquals(8, strlen($result));
    }

    public function testGenerateRandomStringWithNestedArray()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(8, ['x', ['foo' => 'bar'], 'y', 'z']);
        $this->assertEquals(8, strlen($result));
    }

    public function testGenerateRandomStringWithObject()
    {
        $provider = new RumbleText();
        $obj = new \StdClass();
        $obj->set = 'abcd';
        $obj->group = 'feee';
        $result = $provider->generateRandomString(8, $obj);
        $this->assertEquals(8, strlen($result));
    }

    public function testGenerateRandomStringWithLength()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(2);
        $this->assertEquals(2, strlen($result));
    }

    public function testGenerateRandomStringWithLengthAndChars()
    {
        $provider = new RumbleText();
        $result = $provider->generateRandomString(2, 'aa');
        $this->assertEquals(2, strlen($result));
        $this->assertEquals('aa', $result);
    }

    public function testGenerateRandomPhrase()
    {
        $provider = new RumbleText();

        // This will generate a string with 1 to 5 random words in it
        $result = $provider->generateRandomPhrase();
        $this->assertGreaterThan(1, strlen($result));
        $this->assertLessThan(80, strlen($result));

        // First letter must be uppercase
        $first_letter = $result[0];
        $this->assertGreaterThan(ord('A') - 1, ord($first_letter));
        $this->assertLessThan(ord('Z') + 1, ord($first_letter));
    }

    public function testGenerateRandomPhraseOnlyOne()
    {
        $provider = new RumbleText();

        // Generates a string with only one word
        $result = $provider->generateRandomPhrase(1, 1);
        $this->assertGreaterThan(1, strlen($result));
        $this->assertLessThan(11, strlen($result));

        // First letter must be uppercase
        $first_letter = $result[0];
        $this->assertGreaterThan(ord('A') - 1, ord($first_letter));
        $this->assertLessThan(ord('Z') + 1, ord($first_letter));
    }

    public function testGenerateRandomPhraseAsArray()
    {
        $provider = new RumbleText();

        // Generates a string with only one word
        $result = $provider->generateRandomPhrase(1, 1, true);
        $this->assertTrue(is_array($result));
        $this->assertEquals(1, count($result));
    }

    public function testGenerateRandomSentence()
    {
        $provider = new RumbleText();

        // Generates a random sentence
        $result = $provider->generateRandomSentence();
        $this->assertEquals(ucfirst($result), $result);

        // Make a bunch of sentences to ensure no errors with the probabilities
        // baked in (commas, quotes)
        for ($i = 0; $i < 25; $i++) {
            $result = $provider->generateRandomSentence();
        }
    }

    public function testGenerateRandomSentenceAsArray()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomSentence(1, 10, true);
        $this->assertTrue(is_array($result));
    }

    public function testGenerateRandomParagraph()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomParagraph();
        $this->assertEquals(ucfirst($result), $result);
        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomParagraphMinMax()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomParagraph(1, 10);
        $this->assertEquals(ucfirst($result), $result);
        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomParagraphExactWordcount()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomParagraph(1, 6, 50);
        $this->assertEquals(ucfirst($result), $result);
        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomParagraphExactWordcountLarge()
    {
        $provider = new RumbleText();

        // Getting 150 words out of 1 to 2 sentences is difficult
        $result = $provider->generateRandomParagraph(1, 2, 150);
        $this->assertEquals(ucfirst($result), $result);
        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomParagraphAsArray()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomParagraph(1, 7, null, true);
        $this->assertTrue(is_array($result));
    }

    public function testGenerateRandomParagraphExactWordcountAndAsArray()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomParagraph(1, 7, 10, true);
        $this->assertTrue(is_array($result));
        $this->assertEquals(10, count($result));
    }

    public function testGenerateRandomArticle()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomArticle();
        $this->assertEquals(ucfirst($result), $result);
    }

    public function testGenerateRandomArticleMinMax()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomArticle(1, 1);
        $this->assertEquals(ucfirst($result), $result);
    }

    public function testGenerateRandomArticleExactWords()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomArticle(1, 1, 100);
        $this->assertEquals(ucfirst($result), $result);

        // Generate some more to ensure no errors with probabilities
        for ($i = 0; $i < 25; $i++) {
            $result = $provider->generateRandomArticle(1, 10, 5);
        }
    }

    public function testGenerateRandomWord()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord();
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(11, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordLength()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(3);
        $this->assertGreaterThan(2, strlen($result));
        $this->assertLessThan(8, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordLowercase()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true);
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(12, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordUppercaseFirstLetter()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true, true);
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(12, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomWordUppercaseAll()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true, true, true);
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(12, strlen($result));

        // Will be uppercase
        $this->assertSame(strtoupper($result), $result);

        $result = $provider->generateRandomWord(5, false, false, true);
        $this->assertSame(strtoupper($result), $result);
    }

    public function testGenerateRandomWordExactLength()
    {
        $provider = new RumbleText();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true, false, false, true);

        // Will be exact case
        $this->assertSame(5, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomName()
    {
        $provider = new RumbleText();

        // Generates a random name
        $result = $provider->generateRandomName();

        // Will be only 10 chars max
        $this->assertLessThan(11, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomNameMaxlength()
    {
        $provider = new RumbleText();

        // Generates a random name
        $result = $provider->generateRandomName(4);

        // Will be only 10 chars max
        $this->assertLessThan(5, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomCompany()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomCompany();

        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomWebsite()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomWebsite();

        $this->assertContains('.', $result);
    }

    public function testGenerateRandomEmail()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomEmail();

        $this->assertContains('@', $result);
        $this->assertContains('.', $result);
    }

    public function testGenerateRandomDigits()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomDigits();

        $this->assertStringMatchesFormat('%i', $result);
    }

    public function testGenerateRandomDigitsMin()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomDigits(10);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertGreaterThan(9, strlen($result));
    }

    public function testGenerateRandomDigitsMinAndMax()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomDigits(10, 100);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertGreaterThan(9, strlen($result));
        $this->assertLessThan(101, strlen($result));
    }

    public function testGenerateRandomDigitsExactLength()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomDigits(0, 0, 52);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertEquals(52, strlen($result));
    }

    public function testGenerateRandomPhone()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomPhone();

        $this->assertContains('-', $result);
    }

    public function testGenerateRandomAddress()
    {
        $provider = new RumbleText();

        $result = $provider->generateRandomAddress();
        $this->assertContains(' ', $result);
    }

    public function testSeed()
    {
        // After seeding, the results should be the same
        $provider = new RumbleText();
        $provider->seed(1);
        $first = $provider->generateRandomString();
        $second = $provider->generateRandomString();

        $provider = new RumbleText();
        $provider->seed(1);
        $third = $provider->generateRandomString();
        $fourth = $provider->generateRandomString();
        $this->assertEquals($first, $third);
        $this->assertEquals($second, $fourth);

        // After making a new object and not reseeding, it should not be the
        // same as before
        $provider = new RumbleText();
        $fifth = $provider->generateRandomString();
        $this->assertNotEquals($fifth, $first);
    }

    public function testRandomChance()
    {
        // probability 1 is always true
        $result = RumbleText::randomChance(1);
        $this->assertTrue($result);

        // probability 0 is always false
        $result = RumbleText::randomChance(0);
        $this->assertFalse($result);

        // With a fifty-fifty chance we should get around 50
        $true_count = 0;
        for ($i = 0; $i <= 100; $i++) {
            $result = RumbleText::randomChance();
            if ($result) {
                $true_count++;
            }
        }
        $this->assertGreaterThan(45, $true_count);
        $this->assertLessThan(55, $true_count);

        // Try some variations of probability
        $result = RumbleText::randomChance(0.1);
        $this->assertTrue(is_bool($result));

        // Try some variations of probability
        $result = RumbleText::randomChance(0.01);
        $this->assertTrue(is_bool($result));

        // Try some variations of probability
        $result = RumbleText::randomChance(0.001);
        $this->assertTrue(is_bool($result));

        // What if it is bigger than 1?
        // It should scale appropriately - this assumes 2 out of 10
        $result = RumbleText::randomChance(2);
        $this->assertTrue(is_bool($result));

        // This assumes 20%
        $result = RumbleText::randomChance(20);
        $this->assertTrue(is_bool($result));

        // This assumes 100%
        $result = RumbleText::randomChance(100);
        $this->assertTrue($result);

        // What about a negative number?
        $result = RumbleText::randomChance(-1);
        $this->assertTrue($result);

        $result = RumbleText::randomChance(-100);
        $this->assertTrue($result);

        // What about a string?
        $this->expectException(\TypeError::class);
        $result = RumbleText::randomChance("a");
    }

    public function testImplodeRecur()
    {
        $f = ['a', 'b'];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('ab', $r);

        $f = ['foo' => 'bar'];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('bar', $r);

        $f = ['a', 'b', ['foo' => 'bar'], 'c'];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('abbarc', $r);

        $f = ['a', 'b', ['foo' => ['x', 'y', 'bar']], 'c'];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('abxybarc', $r);

        $f = ['aa', 'bb', ['foo' => ['xx', 'yy', 'bar']], 'cc'];
        $r = RumbleText::implode_recur('-', $f);
        $this->assertEquals('aa-bb-xx-yy-bar-cc', $r);

        $f = 1;
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('1', $r);

        $f = [1, 3, 800];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('13800', $r);

        $f = [0.1, 0.66, 0.5, 'a'];
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('0.10.660.5a', $r);

        $f = new \StdClass();
        $f->foo = 'bat';
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('bat', $r);

        $s = new \StdClass();
        $s->type = 'classy';
        $f = new \StdClass();
        $f->name = 'Susan';
        $f->verb = 'is';
        $f->sub = $s;
        $r = RumbleText::implode_recur(' ', $f);
        $this->assertEquals('Susan is classy', $r);

        $f = new \ArrayIterator([1, 2, 3]);
        $r = RumbleText::implode_recur('', $f);
        $this->assertEquals('123', $r);

        $f = function() { return 1; };
        $r = RumbleText::implode_recur('', $f());
        $this->assertEquals('1', $r);
    }
}
