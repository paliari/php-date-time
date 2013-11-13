<?php

use Paliari\DateTime\TDateTime;

class MigracaoTest extends PHPUnit_Framework_TestCase
{
    /**
     * Zend_Date @var
     */
    private $zDate;

    /**
     * TDateTime @var
     */
    private $tDate;

    /**
     * Zend_Date @var
     */
    private $zDate1;

    /**
     * TDateTime @var
     */
    private $tDate1;

    /**
     * Inicializa as variaveis $tDate e $zDate
     */
    public function __construct()
    {
        $this->zDate  = new Zend_Date('2013-05-13 15:15:34');
        $this->zDate1 = new Zend_Date('2013-11-13 15:15:34');
        $this->tDate  = new TDateTime('2013-05-13 15:15:34');
        $this->tDate1 = new TDateTime('2013-11-13 15:15:34');
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testTimestamp()
    {
        $this->assertEquals($this->tDate->getTimestamp(), $this->zDate->getTimestamp());
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddYear()
    {
        $this->assertEquals($this->zDate->addYear(2)->toString('Y'), $this->tDate->addYear(2)->toString('Y'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddMonth()
    {
        $this->assertEquals($this->zDate->addMonth(2)->toString('M'), $this->tDate->addMonth(2)->toString('m'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddDay()
    {
        $this->assertEquals($this->zDate->addDay(2)->toString('d'), $this->tDate->addDay(2)->toString('d'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddHour()
    {
        $this->assertEquals($this->zDate->addHour(2)->toString('H'), $this->tDate->addHour(2)->toString('H'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddMinute()
    {
        $this->assertEquals($this->zDate->addMinute(2)->toString('m'), $this->tDate->addMinute(2)->toString('i'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testAddSecond()
    {
        $this->assertEquals($this->zDate->addSecond(2)->toString('s'), $this->tDate->addSecond(2)->toString('s'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubYear()
    {
        $this->assertEquals($this->zDate->subYear(2)->toString('Y'), $this->tDate->subYear(2)->toString('Y'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubMonth()
    {
        $this->assertEquals($this->zDate->subMonth(2)->toString('M'), $this->tDate->subMonth(2)->toString('m'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubDay()
    {
        $this->assertEquals($this->zDate->subDay(2)->toString('d'), $this->tDate->subDay(2)->toString('d'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubHour()
    {
        $this->assertEquals($this->zDate->subHour(2)->toString('H'), $this->tDate->subHour(2)->toString('H'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubMinute()
    {
        $this->assertEquals($this->zDate->subMinute(2)->toString('m'), $this->tDate->subMinute(2)->toString('i'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSubSecond()
    {
        $this->assertEquals($this->zDate->subSecond(2)->toString('s'), $this->tDate->subSecond(2)->toString('s'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetYear()
    {
        $this->assertEquals($this->zDate->setYear(2)->toString('Y'), $this->tDate->setYear(2)->toString('Y'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetMonth()
    {
        $this->assertEquals($this->zDate->setMonth(2)->toString('M'), $this->tDate->setMonth(2)->toString('m'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetDay()
    {
        $this->assertEquals($this->zDate->setDay(2)->toString('d'), $this->tDate->setDay(2)->toString('d'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetHour()
    {
        $this->assertEquals($this->zDate->setHour(2)->toString('H'), $this->tDate->setHour(2)->toString('H'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetMinute()
    {
        $this->assertEquals($this->zDate->setMinute(2)->toString('m'), $this->tDate->setMinute(2)->toString('i'));
    }

    /**
     * Verifica se as duas funcoes tem o mesmo resultado
     */
    public function testSetSecond()
    {
        $this->assertEquals($this->zDate->setSecond(2)->toString('s'), $this->tDate->setSecond(2)->toString('s'));
    }

//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetYear()
//    {
//        $this->assertEquals($this->zDate->getYear(), $this->tDate->getYear());
//    }
//
//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetMonth()
//    {
//        $this->assertEquals($this->zDate->getMonth(), $this->tDate->getMonth());
//    }
//
//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetDay()
//    {
//        $this->assertEquals($this->zDate->getDay(), $this->tDate->getDay());
//    }
//
//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetHour()
//    {
//        $this->assertEquals($this->zDate->getHour(), $this->tDate->getHour());
//    }
//
//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetMinute()
//    {
//        $this->assertEquals($this->zDate->getMinute(), $this->tDate->getMinute());
//    }
//
//    /**
//     * Verifica se as duas funcoes tem o mesmo resultado
//     */
//    public function testGetSecond()
//    {
//        $this->assertEquals($this->zDate->getSecond(), $this->tDate->getSecond());
//    }

    /**
     * Compara se a data de origem é maior ou menor que a data passada
     * Se for menor retorna -1, se for igual retorna 0, se for maior retorna 1
     */
    public function testCompare()
    {
        $this->assertEquals($this->zDate->compare($this->zDate1), $this->tDate->compare($this->tDate1));
        $this->assertEquals($this->zDate1->compare($this->zDate), $this->tDate1->compare($this->tDate));
        $this->assertEquals($this->zDate->compare($this->zDate), $this->tDate->compare($this->tDate));
    }

    /**
     * Verifica se o objeto é uma data.
     */
    public function testIsDate()
    {

    }
}
