<?php
declare(strict_types=1);

define('S0', 0);
define('S1', 1);
define('S2', 2);

use App\StateMachine;
use PHPUnit\Framework\TestCase;

final class StateMachineTest extends TestCase
{
    protected $sm;

    protected function setUp(): void
    {
        $this->sm = new StateMachine();
        $this->sm->setStates([S0, S1, S2]);
        $this->sm->setInputs(['0', '1']);
        $this->sm->addTransition(S0, '0', S0);
        $this->sm->addTransition(S0, '1', S1);
        $this->sm->addTransition(S1, '1', S0);
        $this->sm->addTransition(S1, '0', S2);
        $this->sm->addTransition(S2, '0', S1);
        $this->sm->addTransition(S2, '1', S2);
    }

    public function testHasInitialState(): void
    {
        $this->assertEquals(S0, $this->sm->getActiveState());

        $this->sm->setInitialState(S1);
        $this->assertEquals(S1, $this->sm->getActiveState());
    }

    public function testCanAddTransition(): void
    {
        $n = count($this->sm->getTransitions());
        $this->assertEquals(6, $n);
    }

    public function testHasStates(): void
    {
        $n = count($this->sm->getStates());
        $this->assertEquals(3, $n);
    }

    private function setUnsignedBinary($input)
    {
        $array = str_split($input);
        foreach ($array as $char) {
            $this->sm->update($char);
        }
    }

    public function testThirteenModThree(): void
    {
        $this->setUnsignedBinary("1101");
        $this->assertEquals(1, $this->sm->getActiveState());
    }

    public function testFourteenModThree(): void
    {
        $this->setUnsignedBinary("1110");
        $this->assertEquals(2, $this->sm->getActiveState());
    }

    public function testFifteenModThree(): void
    {
        $this->setUnsignedBinary("1111");
        $this->assertEquals(0, $this->sm->getActiveState());
    }
}