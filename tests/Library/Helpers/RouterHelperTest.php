<?php

namespace Mitquinn\Hrs\Tests\Library\Helpers;

use Mitquinn\Hrs\Helpers\RouterHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class RouterHelper
 * @package Mitquinn\Hrs\Tests\Library\Helpers
 */
class RouterHelperTest extends TestCase
{

    /**
     * @return array;
     */
    public function extractWildCardsDataProvider()
    {
        return [
            ['/test/1', '/test/{id}', '1'],
            ['/wow/alright', '/wow/{string}', 'alright']
        ];
    }

    /**
     * @dataProvider extractWildCardsDataProvider
     * @param string $path
     * @param string $routePath
     * @param $expectedValue
     */
    public function testExtractWildCards(string $path, string $routePath, string $expectedValue)
    {
        $wildCards = RouterHelper::extractWildCards($path, $routePath);
        static::assertIsArray($wildCards);
        static::assertContains($expectedValue, $wildCards);
    }


    /**
     * @return array[]
     */
    public function matchPathsDataProvider()
    {
        return [
            ['/test/wow', '/test/wow', true],
            ['/test/wow/deeper', '/test/wow/deeper', true],
            ['/test/wow/1/deeper', '/test/wow/{id}/deeper', true],
            ['/test/wow/1/deeper', '/test/wow/{id}/nope', false],
            ['/nope/wow/1/deeper', '/test/wow/{id}/deeper', false],
            ['/strange/wow/1/deeper', '/{id}/wow/{id}/deeper', true],
            ['/strange/wow/1/deeper', '/{id}/wow/2/deeper', false],
            ['/strange/wow/1', '/{this}/{is}/{silly}', true],

        ];
    }

    /**
     * @dataProvider matchPathsDataProvider
     * @param string $path
     * @param string $routePath
     * @param $expectedBool
     */
    public function testMatchPaths(string $path, string $routePath, $expectedBool)
    {
        $realBool = RouterHelper::matchPaths($path, $routePath);
        static::assertEquals($expectedBool, $realBool);
    }

    /**
     * Testing long path.
     */
    public function testExplodePath()
    {
        $pathArray = RouterHelper::explodePath('/this/is/a/very/long/path');
        static::assertIsArray($pathArray);
        static::assertContains('this', $pathArray);
        static::assertContains('is', $pathArray);
        static::assertContains('a', $pathArray);
        static::assertContains('very', $pathArray);
        static::assertContains('long', $pathArray);
        static::assertContains('path', $pathArray);
    }

    /**
     * Testing Path with extra slash. (Extras should be dropped).
     */
    public function testExplodePathExtraSlashes()
    {
        $pathArray = RouterHelper::explodePath('/one//two//three///');
        static::assertIsArray($pathArray);
        static::assertCount(3, $pathArray);
        static::assertContains('one', $pathArray);
        static::assertContains('two', $pathArray);
        static::assertContains('three', $pathArray);
    }

    /**
     * @return array[]
     */
    public function isWildCardDataProvider()
    {
        return [
            ['{}', true],
            ['}{', false],
            ['{data}', true],
            ['{data', false],
            ['data}', false],
        ];
    }

    /**
     * @dataProvider isWildCardDataProvider
     * @param string $string
     * @param bool $expected
     */
    public function testIsWildCard(string $string, bool $expected)
    {
        $realBool = RouterHelper::isWildCard($string);
        static::assertEquals($expected, $realBool);
    }

    /**
     * @return array[]
     */
    public function buildResourcePathsDataProvider()
    {
        return [
            ['one', 'index', '/one'],
            ['one', 'get', '/one/{id}'],
            ['one.two', 'create', '/one/{id}/two'],
            ['one.two', 'get', '/one/{id}/two/{id}'],
            ['one.two.three', 'update', '/one/{id}/two/{id}/three/{id}'],
            ['one.two.three', 'delete', '/one/{id}/two/{id}/three/{id}'],
        ];
    }


    /**
     * @dataProvider buildResourcePathsDataProvider
     * @param string $string
     * @param string $key
     * @param string $expected
     */
    public function testBuildResourcePaths(string $string, string $key, string $expected)
    {
        $pathsArray = RouterHelper::buildResourcePaths($string);
        static::assertIsArray($pathsArray);
        static::assertArrayHasKey('index', $pathsArray);
        static::assertArrayHasKey('get', $pathsArray);
        static::assertArrayHasKey('create', $pathsArray);
        static::assertArrayHasKey('update', $pathsArray);
        static::assertArrayHasKey('delete', $pathsArray);
        static::assertEquals($expected, $pathsArray[$key]);
    }

}