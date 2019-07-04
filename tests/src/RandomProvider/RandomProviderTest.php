<?php

use PHPUnit\Framework\TestCase;

use RandomProvider\RandomProvider;

final class RandomProviderTest extends TestCase
{
    public function testConstruct()
    {
        $provider = new RandomProvider();
        $this->assertInstanceOf(RandomProvider::class, $provider);
        $this->assertEquals(RandomProvider::LETTERSET_ORIGINAL, $provider->letterset);
        $this->assertEquals('aaaeeeeiioouy', $provider->vowels);
    }

    public function testConstructLettersetEqual()
    {
        $provider = new RandomProvider('equal');
        $this->assertEquals(RandomProvider::LETTERSET_EQUAL, $provider->letterset);
        $this->assertEquals('aeiou', $provider->vowels);
    }

    public function testConstructLettersetBaba()
    {
        $provider = new RandomProvider(RandomProvider::LETTERSET_BABA);
        $this->assertEquals(RandomProvider::LETTERSET_BABA, $provider->letterset);
        $this->assertSame(1, strlen($provider->vowels));
        $this->assertSame(1, count($provider->consonants));
    }

    public function testConstructLettersetCaesar()
    {
        $provider = new RandomProvider(RandomProvider::LETTERSET_CAESAR);
        $this->assertEquals(RandomProvider::LETTERSET_CAESAR, $provider->letterset);
        $this->assertGreaterThan(2000, strlen($provider->vowels));
    }

    public function testConstructLettersetHayden()
    {
        $provider = new RandomProvider(RandomProvider::LETTERSET_HAYDEN);
        $this->assertEquals(RandomProvider::LETTERSET_HAYDEN, $provider->letterset);
        $this->assertGreaterThan(2000, strlen($provider->vowels));
    }

    public function testConstructInvalidLetterset()
    {
        $this->expectException(\Exception::class);
        $provider = new RandomProvider('foobar');
    }

    public function testGenerateRandomString()
    {
        $provider = new RandomProvider();
        $result = $provider->generateRandomString();
        $this->assertEquals(8, strlen($result));
    }

    public function testGenerateRandomStringWithLength()
    {
        $provider = new RandomProvider();
        $result = $provider->generateRandomString(2);
        $this->assertEquals(2, strlen($result));
    }

    public function testGenerateRandomStringWithLengthAndChars()
    {
        $provider = new RandomProvider();
        $result = $provider->generateRandomString(2, 'aa');
        $this->assertEquals(2, strlen($result));
        $this->assertEquals('aa', $result);
    }

    public function testGenerateRandomPhrase()
    {
        $provider = new RandomProvider();

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
        $provider = new RandomProvider();

        // Generates a string with only one word
        $result = $provider->generateRandomPhrase(1, 1);
        $this->assertGreaterThan(1, strlen($result));
        $this->assertLessThan(10, strlen($result));

        // First letter must be uppercase
        $first_letter = $result[0];
        $this->assertGreaterThan(ord('A') - 1, ord($first_letter));
        $this->assertLessThan(ord('Z') + 1, ord($first_letter));
    }

    public function testGenerateRandomWord()
    {
        $provider = new RandomProvider();

        // Generates a string using letterset
        $result = $provider->generateRandomWord();
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(11, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordLength()
    {
        $provider = new RandomProvider();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(3);
        $this->assertGreaterThan(2, strlen($result));
        $this->assertLessThan(8, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordLowercase()
    {
        $provider = new RandomProvider();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true);
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(12, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomWordUppercaseFirstLetter()
    {
        $provider = new RandomProvider();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true, true);
        $this->assertGreaterThan(4, strlen($result));
        $this->assertLessThan(12, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomWordUppercaseAll()
    {
        $provider = new RandomProvider();

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
        $provider = new RandomProvider();

        // Generates a string using letterset
        $result = $provider->generateRandomWord(5, true, false, false, true);

        // Will be exact case
        $this->assertSame(5, strlen($result));

        // Will be lowercase
        $this->assertSame(strtolower($result), $result);
    }

    public function testGenerateRandomName()
    {
        $provider = new RandomProvider();

        // Generates a random name
        $result = $provider->generateRandomName();

        // Will be only 10 chars max
        $this->assertLessThan(11, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomNameMaxlength()
    {
        $provider = new RandomProvider();

        // Generates a random name
        $result = $provider->generateRandomName(4);

        // Will be only 10 chars max
        $this->assertLessThan(5, strlen($result));

        // Will be first letter uppercase
        $this->assertSame(ucfirst(strtolower($result)), $result);
    }

    public function testGenerateRandomCompany()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomCompany();

        $this->assertContains(' ', $result);
    }

    public function testGenerateRandomWebsite()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomWebsite();

        $this->assertContains('.', $result);
    }

    public function testGenerateRandomEmail()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomEmail();

        $this->assertContains('@', $result);
        $this->assertContains('.', $result);
    }

    public function testGenerateRandomDigits()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomDigits();

        $this->assertStringMatchesFormat('%i', $result);
    }

    public function testGenerateRandomDigitsMin()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomDigits(10);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertGreaterThan(9, strlen($result));
    }

    public function testGenerateRandomDigitsMinAndMax()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomDigits(10, 100);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertGreaterThan(9, strlen($result));
        $this->assertLessThan(101, strlen($result));
    }

    public function testGenerateRandomDigitsExactLength()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomDigits(0, 0, 52);

        $this->assertStringMatchesFormat('%i', $result);
        $this->assertEquals(52, strlen($result));
    }

    public function testGenerateRandomPhone()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomPhone();

        $this->assertContains('-', $result);
    }

    public function testGenerateRandomAddress()
    {
        $provider = new RandomProvider();

        $result = $provider->generateRandomAddress();
        $this->assertContains(' ', $result);
    }
}
