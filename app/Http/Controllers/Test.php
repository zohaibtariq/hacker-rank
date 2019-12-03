<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use My\Space\ExceptionNamespaceTest;

class Test extends Controller
{
/*    public function callme($param){
        return "call me with : " . $param;
    }*/

/*    public function __construct()
    {
        echo "i am __construct\n";
    }

    public function abc(){
        echo "i am abc\n";
    }*/
//    public function TESTZ(){
//
//    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
//        echo "i m invoke\n";
        //dd('i m invoke');
//        $a = [];
//        $a[1] = 'a';
//        $a[6] = 'b';
//        $a[2] = 'c';
//        $a[99.1] = 'z1';
//        $a[99.2] = 'z2';
//        $a['99.1'] = 'z3';
//        dd($a);

/*        $a = 'a';
        $A = 'A';
        dd($a);*/

//        $array = array(
//            1    => "a",
//            "1"  => "b",
//            1.9  => "c",
//            true => "d",
//        );
//        dd($array);
//        error_reporting(E_ALL);
//        function increment(&$var)
//        {
//            $var++;
//        }
//
//        $a = 0;
//        call_user_func($this->increment, $a);
//        echo $a."\n";
//
//// You can use this instead
//        call_user_func_array($this->increment, array(&$a));
//        echo $a."\n";
//        exit;
//        call_user_func(function($arg) { print "[$arg]\n"; }, 'test');
//        exit;
//        dd('aha');
//        dd((bool)-1);
        // dd(PHP_INT_MIN, PHP_INT_MAX, PHP_INT_SIZE);
//        $grades = [86,30,0,16,51,53,42,48,22,69,12,27,34,24,95,16,32,22,52,56,71,95];
//        $final_grades = [];
//        foreach($grades as $grade){
//            $grade = intval($grade);
//            $multiple_of = 5;
//            $next_multiple_is = intval((round($grade)%$multiple_of === 0) ? round($grade) : round(($grade+$multiple_of/2)/$multiple_of)*$multiple_of);
//            $next_multiple_of_5 = $next_multiple_is;
//            if($grade < 38)
//                $final_grades[] = $grade;
//            else if(($next_multiple_of_5 - $grade) < 3)
//                $final_grades[] = $next_multiple_of_5;
//            else if(($next_multiple_of_5 - $grade) === 3)
//                $final_grades[] = $grade;
//            else
//                $final_grades[] = $grade;
//        }
//        dd($grades, $final_grades === [86,30,0,16,51,55,42,50,22,70,12,27,34,24,95,16,32,22,52,56,71,95]);
    }

//    function nextMultiple($number,$multiple_of=5) {
//        return (round($number)%$multiple_of === 0) ? round($number) : round(($number+$multiple_of/2)/$multiple_of)*$multiple_of;
//    }
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
/*$my_obj = new Test();
$action = "callme";
if ( method_exists($my_obj, $action) ){
    dd($my_obj->{$action}('imparam'));
}*/
/*class Func {
    public static function fromFunction($name){
        return new Func($name);
    }
    public static function fromClassMethod($class, $name){
        return new Func(array($class, $name));
    }
    public static function fromObjectMethod($object, $name){
        return new Func(array($object, $name));
    }
    public $function;
    public function  __construct($function) {
        $this->function = $function;
    }
    public function __invoke(){
        return call_user_func_array($this->function, func_get_args());
    }
    public function offsetGet(){}
}
$func = Func::fromObjectMethod(new Func(function(){}), "offsetGet");
echo $func(3);*/
//dd((new Test())->TESTZ());
//new Test();
/*function sparkles(Callable $func) {
    $func([1,2,3,4,5]);
    echo "sparkles called\n";
}
class Butterfly {
    public function fly(){
        echo "flying...<br>";
    }
    public function __construct($arr){
        echo "construct called with count of : ".count($arr)."<br>";
    }
    public function __invoke($p) {
        echo "invoke called with count of : ".count($p)."<br>";
    }
}
$bf = new Butterfly(['a']);
$bf([1,2,3]);*/
//$bf->fly();
// $bob = new Butterfly(['a']);
// echo sparkles($bob);
/*
function calling($func){
    $func([1,2,3,4,5]);
}
calling(function($arr){
    echo count($arr);
});
*/
/*class C {
    public function __invoke($name) {
        echo 'Hello ', $name, "\n";
    }
}

$c = new C();
// $c('PHP!');
 call_user_func($c, 'PHP!');*/
/*class Foo {
    public static function doAwesomeThings() {
//        FunctionCaller::callIt('self::someAwesomeMethod');
        FunctionCaller::callIt('Foo::someAwesomeMethod');
    }
    public static function someAwesomeMethod() {
        // fantastic code goes here.
    }
}
class FunctionCaller {
    public static function callIt(callable $func) {
        call_user_func($func);
    }
}
Foo::doAwesomeThings();*/
/*
// An example callback function
function my_callback_function() {
    echo 'hello world!';
}

// An example callback method
class MyClass {
    static function myCallbackMethod() {
        echo 'Hello World!';
    }
}

// Type 1: Simple callback
call_user_func('my_callback_function');

// Type 2: Static class method call
call_user_func(array('MyClass', 'myCallbackMethod'));

// Type 3: Object method call
$obj = new MyClass();
call_user_func(array($obj, 'myCallbackMethod'));

// Type 4: Static class method call (As of PHP 5.2.3)
call_user_func('MyClass::myCallbackMethod');

// Type 5: Relative static class method call (As of PHP 5.3.0)
class A {
    public static function who() {
        echo "A\n";
    }
}

class B extends A {
    public static function who() {
        echo "B\n";
    }
}

call_user_func(array('B', 'parent::who')); // A

// Type 6: Objects implementing __invoke can be used as callables (since PHP 5.3)
class C {
    public function __invoke($name) {
        echo 'Hello ', $name, "\n";
    }
}

$c = new C();
call_user_func($c, 'PHP!');*/
