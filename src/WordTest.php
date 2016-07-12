<?php
/**
 * Created by PhpStorm.
 * User: samantha
 * Date: 01.07.16
 * Time: 10:16
 */

namespace Totara;


class WordTest extends \PHPUnit_Framework_TestCase
{

    public function testSingleLineWord()
    {
        $string = "This is a test";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($string, $result);
    }

    /**
     * @expectedException Totara\Exception\InvalidParameterException
     */
    public function testWrapLengthInvalidParam()
    {
        $word = new Word();
        $word->wrap("This is a test", "0");

    }


    public function testWrapForEmptyString()
    {

        $word = new Word();
        $result = $word->wrap(null, 15);
        $this->assertEquals(null, $result);

    }

    /**
     * @expectedException Totara\Exception\InvalidParameterException
     */
    public function testWrapForZeroLength()
    {
        $string = "This is a test This is a test";
        $word = new Word();
        $word->wrap($string, 0);

    }

    /**
     * @expectedException Totara\Exception\InvalidParameterException
     */
    public function testWrapForMinusLength()
    {
        $string = "This is a test This is a test";
        $word = new Word();
        $word->wrap($string, -2);
    }

    public function testWrapWithTwoLineString()
    {
        $string = "This is a test This is a test";
        $expected = "This is a test\nThis is a test";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

    public function testWrapWithSpace()
    {
        $string = "This is a     test   This  is  a    test";
        $expected = "This is a\ntest   This\nis  a    test";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

    public function testWrapWithNoSpace()
    {
        $string = "ThisIsATestThisIsATestThisIsATest";
        $expected = "ThisIsATestThis\nIsATestThisIsAT\nest";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

    public function testWrapWithLongWords()
    {
        $string = "ThisIsATestThisIsATestThisIsATest This is a test";
        $expected = "ThisIsATestThis\nIsATestThisIsAT\nest This is a\ntest";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

    public function testWrapUtf8Char()
    {

        $string = "මෙම ටෙස්ට් මෙම ටෙස්ට් වේ";
        $expected = "මෙම ටෙස්ට් මෙම\nටෙස්ට් වේ";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

     public function testWrapWithSmallestLength()
    {
        $string = "This is";
        $expected = "T\nh\ni\ns \ni\ns";
        $word = new Word();
        $result = $word->wrap($string, 1);
        $this->assertEquals($expected, $result);
    }

    public function testWrapIncludeNewLines()
    {
        $string = "This is \na test";
        $expected = "This is \na test";
        $word = new Word();
        $result = $word->wrap($string, 15);
        $this->assertEquals($expected, $result);
    }

    public function testWrapWithExtraApaceEndOfWords()
    {
        $string = "test case     ";
        $expected = "test\ncase     ";
        $word = new Word();
        $result = $word->wrap($string, 4);
        $this->assertEquals($expected, $result);
    }

    public function testWrapOneWordWithExtraSpace(){
        $string = "test    ";
        $expected = "test    ";
        $word = new Word();
        $result = $word->wrap($string, 10);
        $this->assertEquals($expected, $result);
    }

    public function wrapWithNewLineAndWrapOnExactWord(){
        $string = "test\ncase";
        $expected = "test\ncase";
        $word = new Word();
        $result = $word->wrap($string, 4);
        $this->assertEquals($expected, $result);

    }

    public function wrapWithTwoStrings(){
        $string = "test case";
        $expected = "tes\nt\ncas\ne";
        $word = new Word();
        $result = $word->wrap($string, 3);
        $this->assertEquals($expected, $result);

    }

} 
