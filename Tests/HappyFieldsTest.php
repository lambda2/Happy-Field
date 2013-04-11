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


require_once '../HappyField.php';

use Happy\HappyField as HappyField;

// Call HappyFieldTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HappyFieldTest::main');
}


require_once 'PHPUnit/Autoload.php';


/**
 * Test class for HappyField.
 * @package     Happy
 * @subpackage  Tests
 * @category    Rules Tests
 * @copyright   Copyright (c) 2013, Lambdaweb
 * @author      Andre Aubin <andre.aubin@lambdaweb.fr>
 * @since       v1.0
 * @link        http://lambda2.github.io/Happy-Field/
 */
class HappyFieldTest extends PHPUnit_Framework_TestCase {

    public $hfield; 

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('HappyFieldTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() { $this->hfield = new HappyField(); }


    /**
     * Returns sample post array
     */
    public function getSamplePost()
    {
        return array(
            'nom' => 'Aubin',
            'prenom' => 'Andre',
            'age' => 20,
            'email' => 'contact@lambdaweb.fr'
        );
    }

    /**
     * tests the rules existence
     * @covers Happy\HappyField::__construct
     * @covers Happy\HappyField::addRule
     * @covers Happy\HappyField::setFields
     * @covers Happy\HappyField::showErrors
     */
    public function testSimpleRuleCheck() {

        $this->hfield->showErrors(false);

        $this->assertTrue(
            $this->hfield->setFields($this->getSamplePost()), 
            'unable to add sample fields to validation.'
            );

        $this->assertTrue(count($this->hfield->getFields()) > 0, 'fields are empty !');

        $this->assertFalse(
            $this->hfield->setFields('Trolololoooo'), 
            'Able to add STRING fields to validation ?'
            );

        $this->assertTrue(count($this->hfield->getFields()) > 0, 'fields are empty !');


        $this->assertFalse(
            $this->hfield->check(), 
            'The HappyField should not check without rules !'
            );

        $this->assertFalse(
            $this->hfield->addRule('nom','donotexists','name'), 
            'The supplied rule is false !'
            );

        $this->assertTrue(
            $this->hfield->addRule('nom','alpha','name'), 
            'The supplied rule (alpha) is true !'
            );

        // var_dump($this->hfield->getFields());

        $this->assertTrue(
            $this->hfield->check(), 
            'The HappyField is correct (name is alphanumeric... no ?)'
            );

        $this->assertTrue(
            $this->hfield->addRule('age','num|naturalNotZero','age'),
            'The supplied rule (alpha) is true !'
            );

        $this->assertTrue(
            $this->hfield->check(), 
            'The HappyField is correct (name is alphanumeric... no ?)'
            );

        $this->assertTrue(
            $this->hfield->addRule('prenom','num','surname'),
            'The supplied rule (num) is false !'
            );

        $this->assertFalse(
            $this->hfield->check(), 
            'The HappyField is not correct (prenom is not a number !)'
            );


    }

    

}

// Call HappyFieldTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'HappyFieldTest::main') {
    HappyFieldTest::main();
}
?>