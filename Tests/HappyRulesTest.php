<?php

/*
 * This file is part of HappyField, a field parser for the Moon Framework.
 * See more at the GitHub page :
 * - Of this project @[ https://github.com/lambda2/Happy-Field ]
 * - Of the Moon project @[ https://github.com/lambda2/Moon ]
 *
 * ----------------------------------------------------------------------------
 * (c) 2013 Lambdaweb - www.lambdaweb.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once '../HappyRules.php';

use Happy\HappyRules as HappyRules;

// Call HappyRulesTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HappyRulesTest::main');
}


require_once 'PHPUnit/Autoload.php';


/**
 * Test class for HappyRules.
 */
class HappyRulesTest extends PHPUnit_Framework_TestCase {


    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('HappyRulesTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }

    /**
     * tests the HappyRules constructor
     * @covers HappyRules::__construct
     * @covers HappyRules::parseRules
     * @covers HappyRules::cleanArray
     */
    public function testConstruct() {
        $err = 'Les regles ne sont pas converties en tableau dans le constructeur de HappyField !';
        $rules = array();
        $rules[] = new HappyRules('testOne','');
        $rules[] = new HappyRules('testTwo','sup');
        $rules[] = new HappyRules('testThree','sup 8');
        $rules[] = new HappyRules('testFour','sup 8 | inf 10');

        foreach ($rules as $rule) {
            $rulesv = $rule->getRules();
            $this->assertTrue(is_array($rulesv),$err);
        }
    }


    /**
     * tests the rules existence
     * @covers HappyRules::checkRulesExists
     * @covers HappyRules::cleanArray
     */
    public function testCheckRulesExists() {
        $errExist = 'Une regle devrait exister, mais ce n\'est pas le cas...';
        $errNotExist = 'Une regle ne devrait pas exister !';

        $rules = new HappyRules('testOne','');
        $this->assertTrue($rules->checkRulesExists(),
            $errExist.$rules->getStrDebugErrors());

        $rules = new HappyRules('testTwo','sup');
        $this->assertTrue($rules->checkRulesExists(),
            $errExist.$rules->getStrDebugErrors());

        $rules = new HappyRules('testThree','sup 8');
        $this->assertTrue($rules->checkRulesExists(),
            $errExist.$rules->getStrDebugErrors());

        $rules = new HappyRules('testFour','sup 8 | inf 10');
        $this->assertTrue($rules->checkRulesExists(),
            $errExist.$rules->getStrDebugErrors());

        $rules = new HappyRules('testFive','blabla 8');
        $this->assertFalse($rules->checkRulesExists(),
            $errNotExist.$rules->getStrDebugErrors());

        $rules = new HappyRules('testSix','sup 8 | blabla 10');
        $this->assertFalse($rules->checkRulesExists(),
            $errNotExist.$rules->getStrDebugErrors());
    }

    /**
     * tests the rules validation
     * @covers HappyRules::checkRulesExists
     * @covers HappyRules::cleanArray
     * @covers HappyRules::checkRules
     * @dataProvider getTestValues
     */
    public function testCheckRulesValid($testValue, $testRules, $expected) {

        $errExist = 'Ce test est incorrect';

        $rules = new HappyRules('test',$testRules);
        $result = $rules->checkRules($testValue);
        $this->assertEquals($expected, $result, $errExist.$rules->getStrFieldErrors());
    }

    /**
     * Returns test values for the testCheckRulesValid test
     */
    public function getTestValues()
    {
        return array(
          array('5','',true),
          array('5','sup 1',true),
          array('5','equ 5',true),
          array(5,'equ 5',true),
          array('5','sup 1|inf 6',true),
          array('7','sup 8',false),
          array('7','inf 6',false),
          array('7','sup 8|inf 6',false),
          array('7','sup 6|equ 6',false),
          array('7','sup 6|inf 6',false)
        );
    }
}

// Call HappyRulesTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'HappyRulesTest::main') {
    HappyRulesTest::main();
}
?>