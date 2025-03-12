<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vsp-q3a.php'; // Include the VSPParserQ3A class

class ConvertColorCodesTest extends TestCase
{
    public function testQ3aConvertAllColorCodes()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        $input = "^1Red ^2Green ^3Blue ^4Yellow ^5Cyan ^6Magenta ^7White ^0Gray";
        $expected = "`#FFFFFF`#FF0000Red `#00FF00Green `#FFFF00Blue `#4444FFYellow `#00FFFFCyan `#FF00FFMagenta `#FFFFFFWhite `#777777Gray";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }

    public function testQ3aConvertEmptyName()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        $input = "";
        $expected = " ";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }

    public function testQ3aConvertColorCodesWithSpecialChar()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        // Input that triggers the continue statement at L:470
        $input = "^fSpecialChar";
        $expected = "`#FFFFFFSpecialChar";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }

    public function testQ3aConvertColorCodesWithHexColor()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        // Input that triggers the marked area
        $input = "^xFF0000Red";
        $expected = "`#FFFFFF`#FF0000Red";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }
    public function testXpConvertAllColorCodes()
    {
        $configData = ["gametype" => "xp"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        $input = "^1Red ^2Green ^3Blue ^4Yellow ^5Cyan ^6Magenta ^7White ^0Gray";
        $expected = "`#e90000Red `#00dd24Green `#f5d800Blue `#2e61c8Yellow `#16b4a5Cyan `#f408f1Magenta `#efefefWhite `#555555Gray";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }
    public function testXpConvertColorCodesWithSpecialChar()
    {
        $configData = ["gametype" => "xp"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        // Input that triggers the special character conversion
        $input = "#23SpecialChar";
        $expected = "`#efefef" . chr(hexdec('23')) . "SpecialChar";
        $this->assertEquals($expected, $parser->convertXPColorCodes($input));
    }
    public function testXpConvertSpecialChars103()
    {
        $configData = ["gametype" => "xp", "xp_version" => 103];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        // Input that triggers the special character conversion for XP version 1.03
        $input = "+A#SpecialChar";
        $expected = "`#efefef@SpecialChar";
        $this->assertEquals($expected, $parser->convertXPColorCodes($input));
    }
}

// Mock classes for StatsAggregator and StatsProcessor
class StatsAggregator {}
class StatsProcessor {}
