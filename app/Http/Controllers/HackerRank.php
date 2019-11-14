<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HackerRank extends Controller
{

    public function __construct()
    {
        $this->script_time_start = 0;
        $this->script_time_end = 0;
        $this->data_time_start = 0;
        $this->data_time_end = 0;
        $this->sort_time_start = 0;
        $this->sort_time_end = 0;
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

    public function check($expected, $wins) {
        $findings = [];
        if(count($expected) === count($wins)){
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

    public function test($request) {
        $filename = $request->case;
        $this->data_time_start = microtime(true);
        $root_files_path = 'hacker-rank'.config('main.DS');
        $stdin = fopen(storage_path($root_files_path . 'input' . $filename . '.txt'), "r");
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
        $stdout = fopen(storage_path($root_files_path . 'output' . $filename . '.txt'), "r");
        $expected = [];
        while(!feof($stdout)){
            $expected[] = intval(fgets($stdout));
        }
        $this->data_time_end = microtime(true);
        $resultDataSet = $this->fightingPits($k, $fighters, $queries, $request);
        $wins = $resultDataSet['wins'];
        $restricted_to = intval($resultDataSet['restricted_to']);
        if($restricted_to > 0){
            $expected = array_splice($expected, 0, $restricted_to);
        }
        if($expected === $wins){
            dd('All Test Cases Passed', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time']);
        }else{
            $result = $this->check($expected, $wins);
            if(!$result){
                dd('All Test Cases Passed', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time']);
            }else{
                dd('Failed Test Cases', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time'], $result);
            }
        }
    }

    public function fightingPits($k, $fighters, $queries, $request) {
        $this->script_time_start = microtime(true);
        $debugQuery = -1; // 5
        if($request->has('r_wins'))
            $restrictWins = intval($request->r_wins);
        else
            $restrictWins = -1;
        $teams = [];
        $teamWins = [];
        for ($team_init = 1; $team_init <= $k; $team_init++) {
            $teams[$team_init] = [];
        }
        foreach($fighters as $fighter) {
            $teams[$fighter[1]][] = $fighter[0];
        }
        $this->sort_time_start = microtime(true);
        foreach($teams as $teamIndex => $team){
            rsort($teams[$teamIndex]);
        }
        $this->sort_time_end = microtime(true);
        $this->script_time_end = microtime(true);
//        return [
//            'script_time' => 'script ' . ($this->script_time_end - $this->script_time_start)/60 . ' Mins ::: ' . ($this->script_time_end - $this->script_time_start) . ' Seconds',
//            'data_time' => 'data ' . ($this->data_time_end - $this->data_time_start)/60 . ' Mins ::: ' . ($this->data_time_end - $this->data_time_start) . ' Seconds',
//            'sort_time' => 'sort ' . ($this->sort_time_end - $this->sort_time_start)/60 . ' Mins ::: ' . ($this->sort_time_end - $this->sort_time_start) . ' Seconds',
//            'wins' => $teamWins,
//            'restricted_to' => $restrictWins,
//        ];
        foreach($queries as $queryIndex => $query) {
            if($query[0] === 1){
                array_unshift($teams[$query[2]], $query[1]);
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
                    dump($teams[$query[1]]);
                    dump('TeamY');
                    dump($teamY);
                    dump($teams[$query[2]]);
                }
                while(count($teamX) > 0 && count($teamY) > 0 ){
                    if($queryIndex === $debugQuery){
                        dump('<<<< while fight starts');
                        dump('Before X fight');
                        dump('TeamX');
                        dump($teamX);
                        dump($teams[$query[1]]);
                        dump('TeamY');
                        dump($teamY);
                        dump($teams[$query[2]]);
                    }
                    array_splice($teamY, 0, $teamX[0]);
                    if($queryIndex === $debugQuery){
                        dump('After X fight');
                        dump('TeamX');
                        dump($teamX);
                        dump($teams[$query[1]]);
                        dump('TeamY');
                        dump($teamY);
                        dump($teams[$query[2]]);
                    }
                    if($queryIndex === $debugQuery){
                        dump('Before Y fight');
                        dump('TeamX');
                        dump($teamX);
                        dump($teams[$query[1]]);
                        dump('TeamY');
                        dump($teamY);
                        dump($teams[$query[2]]);
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
                        dump($teams[$query[1]]);
                        dump('TeamY');
                        dump($teamY);
                        dump($teams[$query[2]]);
                        dump('while fight ends >>>');
                    }
                }
                if($queryIndex === $debugQuery){
                    dump('After Match');
                    dump('TeamX');
                    dump($teamX);
                    dump($teams[$query[1]]);
                    dump('TeamY');
                    dump($teamY);
                    dump($teams[$query[2]]);
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
            if(count($teamWins) === $restrictWins){
                break;
            }
        }
        $this->script_time_end = microtime(true);
        return [
            'script_time' => 'script ' . ($this->script_time_end - $this->script_time_start) . ' Seconds',
            'data_time' => 'data ' . ($this->data_time_end - $this->data_time_start) . ' Seconds',
            'sort_time' => 'sort ' . ($this->sort_time_end - $this->sort_time_start) . ' Seconds',
            'wins' => $teamWins,
            'restricted_to' => $restrictWins,
        ];
    }
}
