<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Morgan extends Controller
{

    public function __construct()
    {
        $this->string = '';
        $this->arr_string = [];
    }

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

    public function concat($string = '', $debug = false){
        $this->arr_string[] = $string;
        $this->string .= $string;
        if($debug){
            dd($string, $this->arr_string, $this->string);
        }
    }

    public function morganAndString($a, $b){
        dd($a, $b);
        $string = '';
        while(isset($a[0]) && isset($b[0])){
            $ord_first_a = ord($a[0]);
            $ord_first_b = ord($b[0]);
            if($ord_first_a < $ord_first_b){
                $string .= $a[0];
                $a = substr($a, 1);
            }
            else if($ord_first_a > $ord_first_b){
                $string .= $b[0];
                $b = substr($b, 1);
            }else if($ord_first_a === $ord_first_b){
                $longer_length = (strlen($a) >= strlen($b))?strlen($a):strlen($b);
                for($counter = 0; $counter < $longer_length; $counter++){
                    if(!isset($a[$counter]) || !isset($b[$counter])){
                        if($a == '' || $b == ''){
                            break;
                        }else{
                            if(!isset($a[$counter])){
                                $string .= $a[0];
                                $a = substr($a, 1);
                                break;
                            }else if(!isset($b[$counter])){
                                $string .= $b[0];
                                $b = substr($b, 1);
                                break;
                            }else{
                                die('Problem Occured');
                            }
                        }
                    }
                    else if(ord($a[$counter]) === ord($b[$counter])){
                        continue;
                    }else if(ord($a[$counter]) < ord($b[$counter])){
                        $string .= $a[0];
                        $a = substr($a, 1);
                        break;
                    }else if(ord($a[$counter]) > ord($b[$counter])){
                        $string .= $b[0];
                        $b = substr($b, 1);
                        break;
                    }
                }
            }
        }
        $remaining_string = (($a !== '' && $b === '')?$a:(($b !== '' && $a === '')?$b:''));
        $string .= $remaining_string;
        return $string;
    }

    public function log($string1 = null, $string2 = null, $take_char = null, $modified_string1 = null, $modified_string2 = null, $final_string = ''){
        return false;
        dump('=== Logging start === ');
        dump('string 1 before : ' . $string1);
        dump('string 2 before : ' . $string2);
        dump('take char : ' . $take_char . ' from ' . (($modified_string1 !== null)? 'string 1':'string 2'));
        if($modified_string1 !== null)
            dump('string 1 after : ' . $modified_string1);
        if($modified_string2 !== null)
            dump('string 2 after : ' . $modified_string2);
        if($final_string !== '')
            dump('final string becomes : ' . $final_string);
        dump('=== Logging end === ');
    }

/*
    public function update($string_num = 0, $concat = '', &$substr){
        $this->concat($concat);
        $substr = &substr($substr, 1);
    }
*/

    public function matched($str = null){
        return false;
        if($str === 'KMNCCCGLIQXPRCEWDGRXNXZAZKMJEATBKNOVATQJJXCMFDQUJKQWVJZDNOYSXYTRDPPHJBCBMCRVMCAKRKLCQYKAUEVQQKAUQEAUEWPDQGHNFBHPXFXAGFMWUXFONMVGVQRMZFWTSIMBGHSGDLCROMQXWKMJSYJQRYVLEUAIHLCQTYHXWYMVLAOKPZPLKUBMYKINQFFOOXAFNYYGJBQKMWCSUTNKTJUVOJRPVYNPPLPPRVVKIVGWJTMQGHWYMTDIUGRKHEULXMGAVVVJJOGKIWRFYGKXOTHXCIYGTTLMMZQIATWDPEKKFTQGQHRRRWIAUPSOVTHYTHLXSXTDJILFXFNYCCLBTSHZHEHOVQFWNYGSNHLBDRRBXWQTECGPPKIIWHGQLILSJWRUUDMTAMNCKTMRFPBBRVXHXPXZUHSPHFDGYYISOJBIQCHZRUICMEHOLKJPEEDXORUXFYFEWCUCMDPOEPADIJNYGLLHEYKBWQRTDLXONRVOLGHCGOZXLAVCQBXZPZLBCEOSSXIRWWAJVYOPZGUSLHKAFFJUNOXVAEJXEMWKVIPMQNDHYDVVQQTWMXPUPNRRXFTFRTNZFESTQBJCKOSIKMXJAFJVXUMZOEJHLKORMLFXLSKNMYMJKSKBVJRDHPVFCLDWYICYXQBZYCAIOQRCGMKTEKDAHBNBILZCUOYSJETBTESGGSUWQWJSMFJORCLRKYRPRWJBKABHUYODSUAITIBDCAQIFSWJUMHQRWNBTRTESXHUIJVNQXQAVUDWIUOFEHKIVGYMKLDBEBZYMEEFFGBEHDVLFGDYSKOSABLCTRVSTMSGAWCTKPKAAMWMXSEIKZBRTVRBQORSFMWHSCMAFRJUGCMNZMLBYLNBCAWOFQPALTPETUCVAMYCPAEBRTKQHZUFEKIYYYHGSEMQCDCMCXNUVRNBLHYVKVASWZQQRRGLFRPZJOWKPQYEILDBWHSIBMCSNYQUCSSEMMJJDITAPMSRPNJMLSYULSJAWXIHZWODBVUDEKOEHGBNLCHFZXGXAZWZCWOCDJVPFSUHASCXVYTNMPWSWBWHGOZDIFSXKSNVBFUOCBDQUIIXBXBGLEHBGIKZTCAXNFLLYZVWCXVDOJLJCBWOKLCLEFGOKQEFMYCWPCLLTUWNSPNDKGEWEQFRDZGOAVGUWLARKGKFLIIPICSVJAPJNDXMZAGWSVWGFABDHIPSUHHVXADPIMJYUAQWQWKPDOIDKGANHZYUOCOWMNMZNHZWQWAHYPPXGGWUKXGLXVFVBZZRZEXZVMYRMNXFWAFDDSZIFZXTPLAPKQODXJIAPHPGPIXUFHXSAFJHEAMEJRKLFFRNYRSAVTRQXCGIAPRJKFDYIPIREXAEAFRKKSOQUIVWSADJBXAXSZBTTOFPAWHMLGSEWUBKOSFYSPUHNZUFWBJYKRWPBAEOUYHMTXOBVCSXFPQTUFCCDYTECZJPQCGIVJGHHOOLAKTCXFCJNFEACQYLNFIQJQAPTNZWXYSFTMOYHUZCUODUFWGRTUJRVDUMDDNMKODMTJFMVOJPFNLXXNPLBSIFZGYJUBGRCKGOUVASOADPNNRUUXEZMFRPNPFOUFZSDJWKGMZLIXFHRKAIRSKIMLSWKFJGMOCEAGFBYLCWELWFZIAZOMOUBNXJVNMDOUBYIFKHXWFMBRDWHRRMQXNHGUSQEMLLWUQJLSXSBNVIHQDIYTTAYEKFFXOOJYOUZGTTOWXHYDDMFXRTADIMKMYBQACKHWUCAWADIRMXNQFPRJVYQJGHFESDAXOARREHNOXWRPRMUGAOIMMTCVHIRQPIQCZNRLLSIAMJNRZNKAWYCOCHEIWNSJRMQUVNNNHRIOCZZ')
            return true;
        else
            return false;
    }

    public function test($request){
        $filename = $request->case;
        $root_files_path = 'hacker-rank'.config('main.DS').'morgan'.config('main.DS');
        $stdin = fopen(storage_path($root_files_path . 'input' . $filename . '.txt'), "r");
        fscanf($stdin, "%d\n", $t);
        $strings = [];
        $test_this_only = 0;
        for ($t_itr = 0; $t_itr < $t; $t_itr++) {
            $a = '';
            fscanf($stdin, "%[^\n]", $a);
            $b = '';
            fscanf($stdin, "%[^\n]", $b);
//             $a = 'JACK';
             $a = 'ABACABA';
//             $b = 'DANIEL';
             $b = 'ABACABA';
            if($test_this_only === $t_itr){
                $result = $this->morganAndString($a, $b);
                // var_dump($result === 'AABAABA', 'AABAABA');
                // dump($result, $a, $b, $this->arr_string, $result);
                // exit;
                $strings[$test_this_only] = $result;
                break;
            }
        }
        fclose($stdin);
        $stdout = fopen(storage_path($root_files_path . 'output' . $filename . '.txt'), "r");
        $expected = [];
        while(!feof($stdout)){
            $expected[] = trim(preg_replace('/\s\s+/', '', fgets($stdout)));
        }
        fclose($stdout);
//        dd($strings[$test_this_only] === 'DAJACKNIEL');
        dd($strings[$test_this_only] === 'AABABACABACABA');
        dd($strings[$test_this_only] === $expected[$test_this_only], count($expected));
        dd(count($strings), count($expected), $expected === $strings);
        dd($expected === $strings);
        //exit;
        // dd(strlen($strings[0]), strlen($expected[0]), $strings[0] === $expected[0], $strings[0], $expected[0]);
        // dd(count($expected) === count($strings), $expected === $strings);
        //dd(count($expected) === count($strings));
        //dd($expected === $strings);
        //dd($strings[1], $expected[1]);
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
