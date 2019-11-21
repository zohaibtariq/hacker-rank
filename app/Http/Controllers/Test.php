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
        //
    }

}
interface MyInterface {
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
}
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

$x = Foo::baz();  // $x is now a `Foo`
dd($x);

class Bar extends Foo
{
}

$z = Bar::baz();  // $z is now a `Foo`
dd($z);*/
class Foo
{
    public static function baz() {
        return new static();
    }
}

class Bar extends Foo
{
}
$wow = Bar::baz();
dd($wow); // $wow is now a `Bar`, even though `baz()` is in base `Foo`
/*
 * shortly: new static() - returns the object of current class, regardless of which classes is extended, and new self() - returns the object from the class in which that method was declared or extended(last version of the function)
 * */
