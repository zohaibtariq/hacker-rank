<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HackerRank extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->test($request->case);
    }

    public function check($expected, $wins) {
        if(count($expected) === count($wins)){
            $findings = [];
            foreach($expected as $index => $expect){
                $win = $wins[$index];
                if($expect !== $win){
                    $issue = new \stdClass();
                    $issue->array_index = $index;
                    $issue->expected = $expect;
                    $issue->win = $win;
                    $findings[] = $issue;
                }
            }
        }
        if(count($findings) > 0)
            return $findings;
        return false;
    }

    public function test($filename) {
        $stdin = fopen(storage_path('hacker-rank\input' . $filename . '.txt'), "r");
        fscanf($stdin, "%[^\n]", $nkq_temp);
        $nkq = explode(' ', $nkq_temp);
        $n = intval($nkq[0]);
        $k = intval($nkq[1]);
        $q = intval($nkq[2]);
        $fighters = array();
        for ($fighters_row_itr = 0; $fighters_row_itr < $n; $fighters_row_itr++) {
            fscanf($stdin, "%[^\n]", $fighters_temp);
            $fighters[] = array_map('intval', preg_split('/ /', $fighters_temp, -1, PREG_SPLIT_NO_EMPTY));
        }
        $queries = array();
        for ($queries_row_itr = 0; $queries_row_itr < $q; $queries_row_itr++) {
            fscanf($stdin, "%[^\n]", $queries_temp);
            $queries[] = array_map('intval', preg_split('/ /', $queries_temp, -1, PREG_SPLIT_NO_EMPTY));
        }
        fclose($stdin);
        $stdout = fopen(storage_path('hacker-rank\output' . $filename . '.txt'), "r");
        $expected = [];
        while(!feof($stdout)){
            $expected[] = intval(fgets($stdout));
        }
        $wins = $this->fightingPits($k, $fighters, $queries);
        if($expected === $wins){
            dd('All Test Cases Passed');
        }else{
            $result = $this->check($expected, $wins);
            if(!$result){
                dd('All Test Cases Passed');
            }else{
                dd('Failed Test Cases', $result);
            }
        }
    }

    public function fightingPits($k, $fighters, $queries) {
        $debugQuery = -1; // 5
        $teams = [];
        $teamWins = [];
        for ($team_init = 1; $team_init <= $k; $team_init++) {
            $teams[$team_init] = [];
        }
        foreach($fighters as $fighter) {
            $teams[$fighter[1]][] = $fighter[0];
        }
        foreach($teams as $teamIndex => $team){
            rsort($teams[$teamIndex]);
        }
        foreach($queries as $queryIndex => $query) {
            if($query[0] === 1){
                array_unshift($teams[$query[2]], $query[1]);
//                rsort($teams[$query[2]]);
            }else{
                $teamX = $teams[$query[1]];
                $teamY = $teams[$query[2]];
                if($queryIndex === $debugQuery){
                    dump('Query => 2 X Y');
                    dump($query);
                    dump('Match Between');
                    dump($query[1]);
                    dump($query[2]);
                    dump('Before Match');
                    dump('TeamX');
                    dump($teamX);
                    dump('TeamY');
                    dump($teamY);
                }
                while(count($teamX) > 0 && count($teamY) > 0 ){
                    if($queryIndex === $debugQuery){
                        dump('<<<< while fight starts');
                        dump('Before X fight');
                        dump('TeamX');
                        dump($teamX);
                        dump('TeamY');
                        dump($teamY);
                    }
                    array_splice($teamY, 0, $teamX[0]);
                    if($queryIndex === $debugQuery){
                        dump('After X fight');
                        dump('TeamX');
                        dump($teamX);
                        dump('TeamY');
                        dump($teamY);
                    }
                    if($queryIndex === $debugQuery){
                        dump('Before Y fight');
                        dump('TeamX');
                        dump($teamX);
                        dump('TeamY');
                        dump($teamY);
                    }
                    if(count($teamY) > 0){
                        if($queryIndex === $debugQuery){
                            dump('Y has first so will fight');
                        }
                        array_splice($teamX, 0, $teamY[0]);
                    }
                    if($queryIndex === $debugQuery){
                        dump('After Y fight');
                        dump('TeamX');
                        dump($teamX);
                        dump('TeamY');
                        dump($teamY);
                        dump('while fight ends >>>');
                    }
                }
                if($queryIndex === $debugQuery){
                    dump('After Match');
                    dump('TeamX');
                    dump($teamX);
                    dump('TeamY');
                    dump($teamY);
                }
                if(count($teamX) > 0){
                    if($queryIndex === $debugQuery){
                        dump('Team X Win');
                        dump($query[1]);
                        dump('Team Y Lose');
                        dump($query[2]);
                    }
                    $teamWins[] = $query[1];
                }else{
                    if($queryIndex === $debugQuery){
                        dump('Team Y Win');
                        dump($query[2]);
                        dump('Team X Lose');
                        dump($query[1]);
                    }
                    $teamWins[] = $query[2];
                }
            }
        }
        return $teamWins;
    }
}
