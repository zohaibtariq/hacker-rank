<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HackerRankBackup extends Controller
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
        $this->team_wins = [];
        $this->matches_done = [];
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
        if(count($findings) > 0)
            return $findings;
        return false;
    }

    public function test($request) {
        $filename = $request->case;
        $this->data_time_start = microtime(true);
        $root_files_path = 'hacker-rank'.config('main.DS').'fighting-pit'.config('main.DS');
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
        if($isTestCasesCountOK && $missing === 0 && $expected === $wins){
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
        if ($request->has('r_wins'))
            $restrict_wins = intval($request->r_wins);
        else
            $restrict_wins = false;
        $this->query_time_start = microtime(true);
        foreach ($queries as $query_index => $query) {
            if (intval($query[0]) === 1) {
                $teams[$query[2]][] = $query[1];
                // need to do update caching during add element
                $team_x = $teams[$query[1]];
                $team_y = $teams[$query[2]];
                $unique_team_x = array_unique($team_x);
                $unique_team_y = array_unique($team_y);
                if($unique_team_x === $unique_team_y){
                    if($team_x === $team_y){
                        $this->matches_done[$query[1].':'.$query[2].':'.count($team_x).':'.count($team_y)] = $query[1];
                    }else{
                        if($unique_team_x[0] === 1 && $unique_team_y[0] === 1){
                            $winner_team = null;
                            if(count($team_x) >= count($team_y) || array_sum($team_x) >= array_sum($team_y)){
                                $winner_team = $query[1];
                                $this->matches_done[$query[1].':'.$query[2].':'.count($team_x).':'.count($team_y)] = $winner_team;
                            }
                            else{
                                $winner_team = $query[2];
                                $this->matches_done[$query[1].':'.$query[2].':'.count($team_x).':'.count($team_y)] = $winner_team;
                            }
                        }else{
                            if(end($team_x) >= count($team_y)){
                                $this->matches_done[$query[1].':'.$query[2].':'.array_sum($team_x).':'.array_sum($team_y)] = $query[1];
                            }else{
                                $this->matches_done[$query[1].':'.$query[2].':'.array_sum($team_x).':'.array_sum($team_y)] = $query[2];
                            }
                        }
                    }
                }
            }else if(intval($query[0]) === 2) {
                $team_x = $teams[$query[1]];
                $team_y = $teams[$query[2]];
                $predicted_winner = false;
                $matchString = $query[1].':'.$query[2].':'.array_sum($team_x).':'.array_sum($team_y);
                if(isset($this->matches_done[$matchString]) && $this->matches_done[$matchString] !== '' && $predicted_winner = $this->matches_done[$matchString]){
                    $this->addWinner($team_x, $team_y, $predicted_winner, $query);
                }
                else if($predicted_winner === false){
                    $unique_team_x = array_unique($team_x);
                    $unique_team_y = array_unique($team_y);
                    if($unique_team_x === $unique_team_y){
                        if($team_x === $team_y){
                            $this->addWinner($team_x, $team_y, $query[1], $query);
                        }else{
                            if($unique_team_x[0] === 1 && $unique_team_y[0] === 1){
                                $team_x = array_diff_assoc($teams[$query[1]], $teams[$query[2]]);
                                $team_y = array_diff_assoc($teams[$query[2]], $teams[$query[1]]);
                                $winner_team = null;
                                if(count($team_x) >= count($team_y)){
                                    $winner_team = $query[1];
                                    $this->addWinner($team_x, $team_y, $winner_team, $query, true);
                                }
                                else{
                                    $winner_team = $query[2];
                                    $this->addWinner($team_x, $team_y, $winner_team, $query, true);
                                }
                            }else{
                                if(end($team_x) >= count($team_y)){
                                    $this->addWinner($team_x, $team_y, $query[1], $query);
                                }else{
                                    $this->addWinner($team_x, $team_y, $query[2], $query);
                                }
                            }
                        }
                    }
                    else if($team_x === $team_y || empty($team_y) || end($team_x) >= count($team_y)){
                        $this->addWinner($team_x, $team_y, $query[1], $query);
                    }else{
                        while(!empty($team_x) && !empty($team_y)){
                            if($team_x === $team_y || empty($team_y) || end($team_x) >= count($team_y)) {
                                break;
                            }
                            array_splice($team_y,  -(end($team_x)));
                            if(!empty($team_y)){
                                array_splice($team_x,-(end($team_y)));
                            }
                        }
                        if(!empty($team_x) && count($team_x) > 0){
                            $this->addWinner($team_x, $team_y, $query[1], $query);
                        }else if(!empty($team_y) && count($team_y) > 0){
                            $this->addWinner($team_x, $team_y, $query[2], $query);
                        }
                    }
                }
            }
            if($restrict_wins !== false && intval($restrict_wins) === count($this->team_wins))
                break;
        }
        $this->query_time_end = microtime(true);
        $this->script_time_end = microtime(true);
        return [
            'script_time' => 'script ' . $this->time_diff_formatted_output($this->script_time_end, $this->script_time_start),
            'data_time' => 'data ' . $this->time_diff_formatted_output($this->data_time_end, $this->data_time_start),
            'sort_time' => 'sort ' . $this->time_diff_formatted_output($this->sort_time_end, $this->sort_time_start),
            'team_time' => 'team ' . $this->time_diff_formatted_output($this->team_time_end, $this->team_time_start),
            'query_time' => 'query ' . $this->time_diff_formatted_output($this->query_time_end, $this->query_time_start),
            'wins' => $this->team_wins,
            'restricted_to' => $restrict_wins,
        ];
    }

    public function addWinner($team_x, $team_y, $team_win, $query, $doCount = false){
        if($team_win === true){
            dd(count($team_x), count($team_y), $team_win, $query, $doCount);
        }
        $this->team_wins[] = $team_win;
        if($doCount === true)
            $this->matches_done[$query[1].':'.$query[2].':'.count($team_x).':'.count($team_y)] = $team_win;
        else
            $this->matches_done[$query[1].':'.$query[2].':'.array_sum($team_x).':'.array_sum($team_y)] = $team_win;
    }

    public function time_diff_formatted_output($start_time, $end_time){
        return sprintf('%f',($start_time - $end_time)) . ' Seconds' . ' | ' . ($start_time - $end_time) . ' Seconds';
//        return sprintf('%f',($start_time - $end_time)) . ' Seconds';
    }
}
