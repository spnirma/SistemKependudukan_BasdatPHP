<?php

namespace Cipika\Component\Behat\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Screenshot Context
 */
class ScreenshotContext extends RawMinkContext implements Context, SnippetAcceptingContext
{

    private $enableScreenshot = true;

    private $screenshotDirectory = '/tmp/cipika_behat';

    public function __construct($enable_screenshot = true, $screenshot_directory = '/tmp/cipika_behat')
    {
        $this->enableScreenshot    = $enable_screenshot;
        $this->screenshotDirectory = $screenshot_directory;
    }


    /**
     * @AfterStep
     */
    public function dumpInfoAfterFailedStep(AfterStepScope $scope)
    {

        if (!$this->enableScreenshot || $scope->getTestResult()->isPassed()) {
            return;
        }

        $session = $this->getSession();
        $page    = $session->getPage();
        $driver  = $session->getDriver();
        $message = '';

        if (!$driver instanceof \Behat\Mink\Driver\Selenium2Driver) {
            return;
        }

        $fileName = date('Ymd_His') . '_' . uniqid();
        $screenshotDirectory = $this->screenshotDirectory;

        if (!file_exists($screenshotDirectory)) {
            mkdir($screenshotDirectory);
        }

        $screenshot = $driver->getScreenshot();
        $screenshotFilePath = $screenshotDirectory . '/' . $fileName . '.png';
        file_put_contents($screenshotFilePath, $screenshot);

        // TODO: ouput message to CLI
        $message .= "\n    Screenshot saved to: " . $screenshotDirectory . "/". $fileName . ".png";
        $message .= "\n    Screenshot available at: " . $screenshotDirectory . "/". $fileName . ".png\n";
        fwrite(STDOUT, $message);
    }
}
