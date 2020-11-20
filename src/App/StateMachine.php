<?php
namespace App;

class StateMachine
{
    private $activeState;
    private $finalStates;
    private $inputs;
    private $states;
    private $transitions;

    public function __construct()
    {
        $this->inputs = [];
        $this->states = [];
        $this->transitions = [];
    }

    public function setStates(array $states)
    {
        $this->states = $states;

        // by default set the active state to the first one
        if (!empty($this->states)) {
            $this->activeState = $states[0];
        }
    }

    public function getStates()
    {
        return $this->states;
    }

    public function setInitialState($state)
    {
        $this->activeState = $state;
    }

    public function getActiveState()
    {
        return $this->activeState;
    }

    public function setInputs(array $inputs)
    {
        $this->inputs = $inputs;
    }

    public function setFinalStates(array $states)
    {
        $this->finalStates = $states;
    }

    /**
     * @param string|integer $source The state where the transition starts
     * @param string $input The value of the input
     * @param string|integer $destination The state where the transition ends
     *
     * @throws Exception When the input is not valid
     */
    public function addTransition($source, $input, $destination)
    {
        if (!in_array($input, $this->inputs)) {
            throw new \Exception('Adding Transition: your input is not valid.');
        }

        $this->transitions[] = [
            'source' => $source,
            'input' => $input,
            'destination' => $destination
        ];
    }

    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * @param string $input The value entered by the user
     *
     * @throws Exception When the value is not a valid input
     */
    public function update($input)
    {
        if (!in_array($input, $this->inputs)) {
            throw new \Exception('Updating State: your input is not valid.');
        }

        foreach ($this->transitions as $transition) {
            if ($transition['input'] === $input && $transition['source'] === $this->activeState) {
                $this->activeState = $transition['destination'];
                return $transition['destination'];
            }
        }
    }
}