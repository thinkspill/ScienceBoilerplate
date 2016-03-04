<?php

namespace thinkspill\Experiments;

use Scientist\Experiment;
use Scientist\Laboratory;
use Scientist\Report;

trait DoesScience
{
    /** @var Experiment */
    private $experiment;

    /**
     * Initializes a new labratory
     *
     * @param string $experimentName
     * @param \Closure $control
     */
    public function makeScienceExperiment($experimentName = 'default experiment', \Closure $control)
    {
        $lab = new Laboratory;
        $this->experiment = $lab->experiment($experimentName)->control($control);
    }

    /**
     * Adds trials to the experiment
     *
     * @param string $name
     * @param \Closure $trial
     */
    public function addExperimentTrial($name = '', \Closure $trial)
    {
        $this->experiment->trial($name, $trial);
    }

    /**
     * Executes the experiment and then runs the reporting
     *
     * @param array ...$inputVars
     */
    public function experimentReport(...$inputVars)
    {
        $report = call_user_func_array([$this->experiment, 'report'], $inputVars);
        $this->reportAndDie($inputVars, $report);
    }

    /**
     * Runs the experiment with no reporting
     *
     * @param array ...$vars
     * @return mixed
     */
    public function runExperiment(...$vars)
    {
        return $this->experiment->run($vars);
    }

    /**
     * Experiment boilerplate code, which would get copy/pasted into
     * the code location that calls the method being refactored and
     * modified to call the correct control and trial methods.
     *
     * The only call that needs to retain the actual arguments of the
     * method under refactor are those in the experimentReport call,
     * due to the use of variable arguments everywhere else.
     *
     * This method is never called directly, it is only a convenient
     * place to hold the experiment code.
     *
     * @param $var is just a placeholder to make my IDE quiet :)
     */
    private function boilerplate($var)
    {
        /** boilerplate start */
        $control = function (...$vars) {
            return call_user_func_array([$this, 'controlMethod'], func_get_args());
        };

        $trial = function (...$vars) {
            return call_user_func_array([$this, 'TrialMethod'], func_get_args());
        };

        $this->makeScienceExperiment('Experiment Name', $control);
        $this->addExperimentTrial('trial 1', $trial);

        ~r($this->experimentReport($var));
        /** boilerplate end */
    }

    /**
     * Retrieve Results from Report object and display a rudimentary report
     *
     * @param $inputVars
     * @param Report $report
     */
    private function reportAndDie($inputVars, Report $report)
    {
        $control = $report->getControl();
        $controlTime = round($control->getTime() * 10, 5);
        $controlVal = $control->getValue();
        r($report->getName(), $inputVars, $controlTime, $controlVal);

        /** @var \Scientist\Result $trial */
        foreach ($report->getTrials() as $name => $trial) {
            $trialTime = round($trial->getTime() * 10, 5);
            if ($trialTime > $controlTime) {
                $diff = ($trialTime - $controlTime) . ' slower';
            } else {
                $diff = ($controlTime - $trialTime) . ' faster';
            }
            $trialVal = $trial->getValue();
            $trialException = $trial->getException();
            $trialIsMatch = $trial->isMatch();
            r($name, $trialIsMatch, $trialTime, $diff, $trialVal, $trialException);
        }
        exit;
    }

    /** method stub for boilerplate method above
     * @param $var
     * @return
     */
    private function controlMethod($var)
    {
        return $var;
    }

    /** method stub for boilerplate method above
     * @param $var
     * @return
     */
    private function TrialMethod($var)
    {
        return $var;
    }
}
