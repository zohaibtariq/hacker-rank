<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Morgan extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->test($request);
    }

    public function morganAndString($a, $b){
        $a = strtoupper($a);
        $b = strtoupper($b);
        $a_length = strlen($a);
        $b_length = strlen($b);
        $length = ($a_length > $b_length)?$a_length:$b_length;
        $all = [];
        $debug = false;
        for($i=0; ($i <= ($length + 1)); $i++){
            if($debug)
                dd($a[0], $b[0]);
            if(!isset($a[0]) || !isset($b[0]))
                break;
            else if(ord($a[0]) < ord($b[0])){
                $all[] = $a[0];
                $a = substr($a, 1);
            }
            else if(ord($a[0]) > ord($b[0])){
                $all[] = $b[0];
                $b = substr($b, 1);
            }else if(ord($a[0]) === ord($b[0])){
                $all[] = $a[0];
                $a = substr($a, 1);
            }
            if(trim(implode('', $all)) === 'FPGNSJXJVQBQGDUVFEPKVCVDBYUJBLZAEJPOVOXCKWAWYOMJCSQZ'){
                $debug = true;
            }
        }
        if($a !== '')
            $all[] = $a;
        if($b !== '')
            $all[] = $b;
        return trim(implode('', $all));
    }

    public function test($request){
        $filename = $request->case;
        $root_files_path = 'hacker-rank'.config('main.DS').'morgan'.config('main.DS');
        $stdin = fopen(storage_path($root_files_path . 'input' . $filename . '.txt'), "r");
        fscanf($stdin, "%d\n", $t);
        $strings = [];
        for ($t_itr = 0; $t_itr < $t; $t_itr++) {
            $a = '';
            fscanf($stdin, "%[^\n]", $a);
            $b = '';
            fscanf($stdin, "%[^\n]", $b);
            $result = $this->morganAndString($a, $b);
            $strings[] = $result;
        }
        fclose($stdin);
        $stdout = fopen(storage_path($root_files_path . 'output' . $filename . '.txt'), "r");
        $expected = [];
        while(!feof($stdout)){
            $expected[] = trim(preg_replace('/\s\s+/', '', fgets($stdout)));
        }
        fclose($stdout);
        //dd(count($expected) === count($strings));
        //dd($expected === $strings);
        dd($strings[1], $expected[1]);
        dd(strlen($strings[0]), strlen($expected[0]));
        dd($strings[0] === $expected[0]);
        dd($strings[1] === $expected[1]);
        dd($strings[2] === $expected[2]);
        dd($strings[3] === $expected[3]);
        dd($strings[4] === $expected[4]);
        dd($strings);
        dd($expected);
    }
}
