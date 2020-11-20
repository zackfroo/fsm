<?php
namespace App;

define('S0', 0);
define('S1', 1);
define('S2', 2);

class Application
{
    public static function run()
    {
        // thirteen
        echo "Result for 1101: ".self::modThree("1101")."<br>"; // 1
        
        // fourteen
        echo "Result for 1110: ".self::modThree("1110")."<br>"; // 2
        
        // fifteen
        echo "Result for 1111: ".self::modThree("1111")."<br>"; // 0
    }

    /**
     * @param string $input The unsigned binary string entered by the user
     */
    private static function modThree($input)
    {
        $sm = new StateMachine();
        $sm->setStates([S0, S1, S2]);
        $sm->setInitialState(S0);
    
        $sm->setInputs(['0', '1']);
    
        $sm->setFinalStates([S0, S1, S2]);
    
        $sm->addTransition(S0, '0', S0);
        $sm->addTransition(S0, '1', S1);
        $sm->addTransition(S1, '1', S0);
        $sm->addTransition(S1, '0', S2);
        $sm->addTransition(S2, '0', S1);
        $sm->addTransition(S2, '1', S2);
    
        $array = str_split($input);
        foreach ($array as $char) {
            $sm->update($char);
        }
    
        return $sm->getActiveState();
    }
}