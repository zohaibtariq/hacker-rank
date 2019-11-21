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
        $string = '';
        $debug = false;
        while(isset($a[0]) && isset($b[0])){
            $ord_first_a = ord($a[0]);
            $ord_first_b = ord($b[0]);
            if($debug){
                dump('while start');
                dump($a[0] . ':' . $ord_first_a . '<>' . $b[0] . ':' . $ord_first_b);
                dd('while end');
            }
            if($ord_first_a < $ord_first_b){
                $string .= $a[0];
                if($this->matched($string))
                    $debug = true;
                $a = substr($a, 1);
            }
            else if($ord_first_a > $ord_first_b){
                $string .= $b[0];
                if($this->matched($string))
                    $debug = true;
                $b = substr($b, 1);
            }else if($ord_first_a === $ord_first_b){
                $ord_second_a = (isset($a[1]))?ord($a[1]):0;
                $ord_second_b = (isset($b[1]))?ord($b[1]):0;
                if(($ord_first_a + $ord_second_a) < ($ord_first_b + $ord_second_b)){
                    $string .= $a[0];
                    if($this->matched($string))
                        $debug = true;
                    $a = substr($a, 1);
                }else{
                    $string .= $b[0];
                    if($this->matched($string))
                        $debug = true;
                    $b = substr($b, 1);
                }
            }
        }
        $debug2 = false;
        $remaining_string = (($a !== '' && $b === '')?$a:(($b !== '' && $a === '')?$b:''));
        $remaining_string_count = strlen($remaining_string);
        for($i=0; $i < $remaining_string_count; $i++){
            if($debug2){
                dump('remaining_string');
                dd($remaining_string);
            }
            $string .= $remaining_string[0];
            if($this->matched($string))
                $debug2 = true;
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
