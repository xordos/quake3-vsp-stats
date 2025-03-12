<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vsp-q3a.php'; // Include the VSPParserQ3A class

class ConvertColorCodesTest extends TestCase
{
    public function testConvertAllQ3aColorCodes()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        $input = "^1Red ^2Green ^3Blue ^4Yellow ^5Cyan ^6Magenta ^7White ^0Gray";
        $expected = "`#FFFFFF`#FF0000Red `#00FF00Green `#FFFF00Blue `#4444FFYellow `#00FFFFCyan `#FF00FFMagenta `#FFFFFFWhite `#777777Gray";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }
    public function testConvertEmptyName()
    {
        $configData = ["gametype" => "q3a"];
        $statsAggregator = $this->createMock(StatsAggregator::class);
        $statsProcessor = $this->createMock(StatsProcessor::class);
        $parser = new VSPParserQ3A($configData, $statsAggregator, $statsProcessor);

        $input = "";
        $expected = " ";
        $this->assertEquals($expected, $parser->convertColorCodes($input));
    }

    public function testConvertColorCodesWithSpecialChar()
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

    public function testConvertColorCodesWithHexColor()
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
}

// Mock classes for StatsAggregator and StatsProcessor
class StatsAggregator {}
class StatsProcessor {}
