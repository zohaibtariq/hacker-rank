<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use My\Space\ExceptionNamespaceTest;

class Test extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $grades = [86,30,0,16,51,53,42,48,22,69,12,27,34,24,95,16,32,22,52,56,71,95];
        $final_grades = [];
        foreach($grades as $grade){
            $grade = intval($grade);
            $multiple_of = 5;
            $next_multiple_is = intval((round($grade)%$multiple_of === 0) ? round($grade) : round(($grade+$multiple_of/2)/$multiple_of)*$multiple_of);
            $next_multiple_of_5 = $next_multiple_is;
            if($grade < 38)
                $final_grades[] = $grade;
            else if(($next_multiple_of_5 - $grade) < 3)
                $final_grades[] = $next_multiple_of_5;
            else if(($next_multiple_of_5 - $grade) === 3)
                $final_grades[] = $grade;
            else
                $final_grades[] = $grade;
        }
        dd($grades, $final_grades === [86,30,0,16,51,55,42,50,22,70,12,27,34,24,95,16,32,22,52,56,71,95]);
    }

    function nextMultiple($number,$multiple_of=5) {
        return (round($number)%$multiple_of === 0) ? round($number) : round(($number+$multiple_of/2)/$multiple_of)*$multiple_of;
    }

}
/*interface MyInterface {
//    public function callMe();
    public function callMe();
}
class MyClass implements MyInterface{
    public function callMe(){
        //
    }
}
abstract class AbstractClass{
    abstract public function absMethod1();
    public function absMethod(){
        return 'abs class abs method';
    }
}
class MyNewClass extends AbstractClass {
    public function absMethod(){
        return 'MyNewClass class abs method';
    }
    public function absMethod1(){
        return 'MyNewClass class abs method';
    }
}*/
//$myNewClass = new MyNewClass();
//dd($myNewClass->absMethod());
/*class MyStaticClass {

}*/
/*class Singleton {
    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }
    protected function __construct() {
    }
    private function __clone() {
    }
    private function __wakeup() {
    }
}
class SingletonChild extends Singleton {
}
$obj = Singleton::getInstance();
var_dump($obj === Singleton::getInstance());
$anotherObj = SingletonChild::getInstance();
var_dump($anotherObj === Singleton::getInstance());
var_dump($anotherObj === SingletonChild::getInstance());*/

/* = = = */
/*class Foo
{
    public static function baz() {
        return new self();
    }
}

$multiple_of = Foo::baz();  // $multiple_of is now a `Foo`
dd($multiple_of);

class Bar extends Foo
{
}

$z = Bar::baz();  // $z is now a `Foo`
dd($z);*/
/*class Foo
{
    public static function baz() {
        return new static();
    }
}

class Bar extends Foo
{
}
$wow = Bar::baz();
dd($wow); // $wow is now a `Bar`, even though `baz()` is in base `Foo`*/
/*
 * shortly: new static() - returns the object of current class, regardless of which classes is extended, and new self() - returns the object from the class in which that method was declared or extended(last version of the function)
 * */
