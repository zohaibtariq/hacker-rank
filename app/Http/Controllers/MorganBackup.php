<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MorganBackup extends Controller
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
//        $string1 = 'AABAB';
//        $string2 = 'AABAA';
//        $arr_string_1 = str_split($string1);
//        $arr_string_2 = str_split($string2);
//        $sum_string_1 = 0;
//        $sum_string_2 = 0;
//        foreach($arr_string_1 as $item){
//            $sum_string_1 += ord($item);
//        }
//        foreach($arr_string_2 as $item){
//            $sum_string_2 += ord($item);
//        }
//        dd($sum_string_1, $sum_string_2);
        // dd($string1 < $string2, ord($string1) < ord($string2), ord($string1), ord($string2));
        // dd(ord('A'),ord('Z'),ord('a'), ord('z'));
        $string = '';
        $debug = false;
        while(isset($a[0]) && isset($b[0])){
            $ord_first_a = ord($a[0]);
            $ord_first_b = ord($b[0]);
//            if($debug){
//                dump('while start');
//                dump($a[0] . ':' . $ord_first_a . '<>' . $b[0] . ':' . $ord_first_b);
//                dump($a, $b, $string);
//                dump(strlen($a), strlen($b), strlen($string));
//                dd('while end');
//            }
            if($ord_first_a < $ord_first_b){
                $string .= $a[0];
//                if($this->matched($string))
//                    $debug = true;
                $a = substr($a, 1);
            }
            else if($ord_first_a > $ord_first_b){
                $string .= $b[0];
//                if($this->matched($string))
//                    $debug = true;
                $b = substr($b, 1);
            }
//            else if($ord_first_a === $ord_first_b && (!isset($a[1]) || !isset($b[1]))){
//                $string .= $a[0];
//                $a = substr($a, 1);
//            }
            else if($ord_first_a === $ord_first_b){
                $string1 = $a;
                $string2 = $b;
                $arr_string_1 = str_split($string1);
                $arr_string_2 = str_split($string2);
                $sum_string_1 = 0;
                $sum_string_2 = 0;
                foreach($arr_string_1 as $item){
                    $sum_string_1 += ord($item);
                }
                foreach($arr_string_2 as $item){
                    $sum_string_2 += ord($item);
                }
                if($sum_string_1 < $sum_string_2){
                    $string .= $a[0];
                    $a = substr($a, 1);
                }else if($sum_string_2 < $sum_string_1){
                    $string .= $b[0];
                    $b = substr($b, 1);
                }
                /*$longer_length = (strlen($a) >= strlen($b))?strlen($a):strlen($b);
                for($counter = 0; $counter < $longer_length; $counter++){
                    if(!isset($a[$counter]) || !isset($b[$counter]))
                        break;
                    if(ord($a[$counter]) === ord($b[$counter])){
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
                exit;
                dump($a[0] . ' and ' . $b[0] . ' are equal out.', $a, $b);*/
            }
        }
        $debug2 = false;
        $remaining_string = (($a !== '' && $b === '')?$a:(($b !== '' && $a === '')?$b:''));
        $remaining_string_count = strlen($remaining_string);
        for($i=0; $i < $remaining_string_count; $i++){
//            if($debug2){
//                dump('remaining_string');
//                dd($remaining_string);
//            }
            $string .= $remaining_string[0];
//            if($this->matched($string))
//                $debug2 = true;
            $remaining_string = substr($remaining_string, 1);
        }
        return $string;
    }

    public function matched($str = null){
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
        for ($t_itr = 0; $t_itr < $t; $t_itr++) {
            $a = '';
            fscanf($stdin, "%[^\n]", $a);
            $b = '';
            fscanf($stdin, "%[^\n]", $b);
            $a = 'AABAABA'; //'YZZYZYYZZYYZYZZY';
            $b = 'AABABAA'; //'ZZYZYYZZYYZYZZY';
            $result = $this->morganAndString($a, $b);
            $strings[] = $result;
            break;
        }
        fclose($stdin);
        $stdout = fopen(storage_path($root_files_path . 'output' . $filename . '.txt'), "r");
        $expected = [];
        while(!feof($stdout)){
            $expected[] = trim(preg_replace('/\s\s+/', '', fgets($stdout)));
        }
        fclose($stdout);
        var_dump($strings[0] === 'AABAABA', $strings[0]);exit;
        /**
        My WRONG output = YZZYZYYZZYYZYZZYZZYZYYZZYYZYZZY

        My RIGHT output = YZZYZYYZZYYZYZZYZYYZZYYZYZZYZZY
         */
        var_dump(strlen($strings[0]), strlen($expected[0]));
        var_dump($strings[0] == $expected[0]);
        var_dump($strings[0]);
        var_dump($expected[0]);
        exit;
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
