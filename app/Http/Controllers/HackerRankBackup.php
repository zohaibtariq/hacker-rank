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
        $this->team_time_start = 0;
        $this->team_time_end = 0;
        $this->query_time_start = 0;
        $this->query_time_end = 0;
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
        $teams = array();
        $this->team_time_start = microtime(true);
        for ($fighters_row_itr = 0; $fighters_row_itr < $n; $fighters_row_itr++) {
            fscanf($stdin, "%[^\n]", $fighters_temp);
            $fighters_data = array_map('intval', preg_split('/ /', $fighters_temp, -1, PREG_SPLIT_NO_EMPTY));
            $teams[$fighters_data[1]][] = $fighters_data[0];
        }
        $this->team_time_end = microtime(true);
        $this->sort_time_start = microtime(true);
        for ($teamIndex = 1; $teamIndex <= $k; $teamIndex++) {
            if(isset($teams[$teamIndex]) && is_array($teams[$teamIndex]))
                sort($teams[$teamIndex]);
            else
                $teams[$teamIndex] = [];
        }
        $this->sort_time_end = microtime(true);
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
        $resultDataSet = $this->fightingPits($request, $teams, $queries);
        $wins = $resultDataSet['wins'];
        $restricted_to = intval($resultDataSet['restricted_to']);
        if($restricted_to > 0){
            $expected = array_splice($expected, 0, $restricted_to);
        }
        $isTestCasesCountOK = count($wins) === count($expected);
        $missing = count(array_diff_assoc($expected, $wins));
        if($isTestCasesCountOK && $missing === 0){
            dd('All Test Cases Passed 1.', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time'], $resultDataSet['team_time'], $resultDataSet['query_time']);
        }else{
            $result = $this->check($expected, $wins);
            if(!$result){
                dd('All Test Cases Passed 2.', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time'], $resultDataSet['team_time'], $resultDataSet['query_time']);
            }else{
                dd('Failed Test Cases', $resultDataSet['script_time'], $resultDataSet['data_time'], $resultDataSet['sort_time'], $resultDataSet['team_time'], $resultDataSet['query_time'], $result);
            }
        }
    }

    public function fightingPits($request, $teams, $queries)
    {
        $this->script_time_start = microtime(true);
        $debugQuery = -1; // 5
        if ($request->has('r_wins'))
            $restrictWins = intval($request->r_wins);
        else
            $restrictWins = false;
        $teamWins = [];
        $this->query_time_start = microtime(true);
//        if (true){
        $matches_done = [];
            foreach ($queries as $queryIndex => $query) {
                if (intval($query[0]) === 1) {
                    //if (false && $query[0] === 1) {
                    // array_unshift($teams[$query[2]], $query[1]);
                    $teams[$query[2]][] = $query[1];
                    // } else if(false) {
                    /*
                    // Aftab start
                    }else{
                        $teamX = $teams[$query[1]];
                        $teamY =$teams[$query[2]];
                        if($teamX===$teamY || empty($teamY) || end($teamX)>=count($teamY))                   {
                            //break;
                        }
                        //    elseif(empty($teamX) || end($teamY)>=count($teamX))
                        //    {
                        //         $teamX = array();
                        //        // break;
                        //    }
                        else{
                            while(!empty($teamX) && !empty($teamY)){
                                if($teamX===$teamY || empty($teamY) || end($teamX)>=count($teamY))                   {
                                    break;
                                }
                                array_splice($teamY,  -(end($teamX)));

                                if(!empty($teamY)){
                                    if(end($teamY)>=count($teamX)){
                                        //unset($teamX);
                                        $teamX = array();
                                        break;
                                    }
                                    array_splice($teamX,-(end($teamY)));
                                }
                            }
                        }

                        if(!empty($teamX)){
                            $teamWins[] = $query[1];
                        }else{
                            $teamWins[] = $query[2];
                        }
                    }
                    // aftab end
                    */
                    /**/
                    // zohaib start
                }else if(intval($query[0]) === 2) {
                    $teamX = $teams[$query[1]];
                    $teamY = $teams[$query[2]];
                    if($teamX === $teamY || empty($teamY) || end($teamX) >= count($teamY) || ((end($teamX) +1 ) === count($teamY) && $teamX[0]===$teamY[0])){
                         $teamWins[] = $query[1];
                         $matches_done[$query[1].':'.$query[2].':'.array_sum($teamX).':'.array_sum($teamY)] = $query[1];
                         continue;
                    }
//                    if($query[1] === 32 && $query[2] === 86){
//                        dd($teamX, $teamY);
//                    }


//                    dd(array_sum($teamX), array_sum($teamY));
//                    dd(count($teamX), count($teamY));
//                    dd($teamX, $teamY);
//                    if ($queryIndex === $debugQuery) {
//                        dump('Query => 2 X Y');
//                        dump($query);
//                        dump('Match Between');
//                        dump($query[1]);
//                        dump($query[2]);
//                        dump('Before Match');
//                        dump('TeamX');
//                        dump($teamX);
//                        dump($teams[$query[1]]);
//                        dump('TeamY');
//                        dump($teamY);
//                        dump($teams[$query[2]]);
//                    }
//                    $canPlay = true;
                    else {
                        $predicted_winner = false;
                        if(isset($matches_done[$query[1].':'.$query[2].':'.array_sum($teamX).':'.array_sum($teamY)]))
                            $predicted_winner = $matches_done[$query[1].':'.$query[2].':'.array_sum($teamX).':'.array_sum($teamY)];
                        if(!$predicted_winner){
                            while(!empty($teamX) && !empty($teamY)){
                                if($teamX === $teamY || empty($teamY) || end($teamX) >= count($teamY) || ((end($teamX) +1 ) === count($teamY) && $teamX[0]===$teamY[0]) ){
                                    dump('break 1 : ');
                                    break;
                                }
                                array_splice($teamY,  -(end($teamX)));
                                if(!empty($teamY)){
                                    if(end($teamY)>=count($teamX)){
                                        $teamX = array();
                                        dump('break 2 : ');
                                        break;
                                    }
                                    array_splice($teamX,-(end($teamY)));
                                }
                            }
                        }else{
                            $teamWins[] = $predicted_winner;
                            dump('continue : ');
                            continue;
                        }
                        /*
                        while (count($teamX) > 0 && count($teamY) > 0 && !in_array($query[1] . ':' . $query[2], $matches_done)) {
//                        $matches_done[] = $query[1].':'.$query[2];
//                        if($query[1] === 95 && $query[2] === 78){
//                            dump('Match Between ' . $query[1] . ' & ' . $query[2]);
//                            dump($matches_done);
//                        }
//                        if ($queryIndex === $debugQuery) {
//                            dump('<<<< while fight starts');
//                            dump('Before X fight');
//                            dump('TeamX');
//                            dump($teamX);
//                            dump($teams[$query[1]]);
//                            dump('TeamY');
//                            dump($teamY);
//                            dump($teams[$query[2]]);
//                        }
                            array_splice($teamY, (intval($teamX[0]) * -1), intval($teamX[0]));
                            //array_splice($teamY, 0, $teamX[0]);
//                        if ($queryIndex === $debugQuery) {
//                            dump('After X fight');
//                            dump('TeamX');
//                            dump($teamX);
//                            dump($teams[$query[1]]);
//                            dump('TeamY');
//                            dump($teamY);
//                            dump($teams[$query[2]]);
//                        }
//                        if ($queryIndex === $debugQuery) {
//                            dump('Before Y fight');
//                            dump('TeamX');
//                            dump($teamX);
//                            dump($teams[$query[1]]);
//                            dump('TeamY');
//                            dump($teamY);
//                            dump($teams[$query[2]]);
//                        }
                            if (count($teamY) > 0) {
//                            if ($queryIndex === $debugQuery) {
//                                dump('Y has first so will fight');
//                            }
                                // array_splice($teamX, 0, $teamY[0]);
                                array_splice($teamX, (intval($teamY[0]) * -1), intval($teamY[0]));
                            }
//                        if ($queryIndex === $debugQuery) {
//                            dump('After Y fight');
//                            dump('TeamX');
//                            dump($teamX);
//                            dump($teams[$query[1]]);
//                            dump('TeamY');
//                            dump($teamY);
//                            dump($teams[$query[2]]);
//                            dump('while fight ends >>>');
//                        }
//                        $canPlay = false;
                            $matches_done[] = $query[1] . ':' . $query[2];
                        }
                        */
                    }
//                    if ($queryIndex === $debugQuery) {
//                        dump('After Match');
//                        dump('TeamX');
//                        dump($teamX);
//                        dump($teams[$query[1]]);
//                        dump('TeamY');
//                        dump($teamY);
//                        dump($teams[$query[2]]);
//                    }

                    // $teamXStrength = array_sum($teamX);
                    // $teamYStrength = array_sum($teamY);
//                   dd(
//                        $teamX, count($teamX), $teamXStrength,
//                        $teamY, count($teamY), $teamYStrength
//                    );
                    // if(($teamXStrength + 1) >= $teamYStrength){
                    /*if (count($teamX) > 0) {
//                        if ($queryIndex === $debugQuery) {
//                            dump('Team X Win');
//                            dump($query[1]);
//                            dump('Team Y Lose');
//                            dump($query[2]);
//                        }
                        $teamWins[] = $query[1];
                    } else {
//                        if ($queryIndex === $debugQuery) {
//                            dump('Team Y Win');
//                            dump($query[2]);
//                            dump('Team X Lose');
//                            dump($query[1]);
//                        }
                        $teamWins[] = $query[2];
                    }*/
                    if(!empty($teamX)){
                        $teamWins[] = $query[1];
                        $matches_done[$query[1].':'.$query[2].':'.array_sum($teamX).':'.array_sum($teamY)] = $query[1];
                    }else{
                        $teamWins[] = $query[2];
                        $matches_done[$query[1].':'.$query[2].':'.array_sum($teamX).':'.array_sum($teamY)] = $query[2];
                    }
                }
//                if ($restrictWins !== false && intval(count($teamWins)) === intval($restrictWins)) {
//                    break;
//                }
                // zohaib end
                /**/
            }
//        }
        $this->query_time_end = microtime(true);
        $this->script_time_end = microtime(true);
        return [
            'script_time' => 'script ' . $this->timeDiffFormattedOutput($this->script_time_end, $this->script_time_start),
            'data_time' => 'data ' . $this->timeDiffFormattedOutput($this->data_time_end, $this->data_time_start),
            'sort_time' => 'sort ' . $this->timeDiffFormattedOutput($this->sort_time_end, $this->sort_time_start),
            'team_time' => 'team ' . $this->timeDiffFormattedOutput($this->team_time_end, $this->team_time_start),
            'query_time' => 'query ' . $this->timeDiffFormattedOutput($this->query_time_end, $this->query_time_start),
            'wins' => $teamWins,
            'restricted_to' => $restrictWins,
        ];
    }

    public function timeDiffFormattedOutput($start_time, $end_time){
        return sprintf('%f',($start_time - $end_time)) . ' Seconds' . ' | ' . ($start_time - $end_time) . 'Seconds';
//        return sprintf('%f',($start_time - $end_time)) . ' Seconds';
    }
}
