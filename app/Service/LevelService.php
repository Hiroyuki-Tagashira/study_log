<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Models\StudyLog;
use App\Models\User;

class LevelService {

    //totalStudyTimeがどのグループに属するか求める。$this->groupNumの間隔は1,2,3,4...18と増えていく。
    private $groupNum;
    //グループ内で何番目か
    private $position;


    //レべり５以下の次のレベルに上がるための経験値量
    private $lowLevelSteps = [
        1 => 5,
        2 => 10,
        3 => 10,
        4 => 15,
        5 => 20,
    ];

    //レベル６以上の基準レベル、次のレベルに上がるための経験値量
    private $levelAndSteps = [
        0 => [6, 30],
        1 => [11, 60],
        3 => [16, 90],
        6 => [21, 120],
        10 => [26, 150],
        15 => [31,180],
        21 => [36, 210],
        28 => [41, 240],
        36 => [46, 270],
        45 => [51, 300],
        55 => [56, 330],
        66 => [61, 360],
        78 => [66, 390],
        91 => [71, 420],
        105 => [76, 450],
        120 => [81, 480],
        136 => [86, 510],
        153 => [91, 540],
        171 => [96, 570],
    ];

    public function getLevel($totalStudyTime) {

        $level = 0;

        if($totalStudyTime < 5) {
            $level = 1;
        } else if($totalStudyTime < 15) {
            $level = 2;
        } else if($totalStudyTime < 25) {
            $level = 3;
        } else if($totalStudyTime < 40) {
            $level = 4;
        } else if($totalStudyTime < 60) {
            $level = 5;
        } else {
            $totalStudyTime -= 60;
            $this->groupNum = $totalStudyTime / 150;
            if($this->groupNum < 1) { //Aグループ
                $this->groupNum = 0;
            } else if($this->groupNum < 3) {
                $this->groupNum = 1;
            } else if($this->groupNum < 6) {
                $this->groupNum = 3;
            } else if($this->groupNum < 10) {
                $this->groupNum = 6;
            } else if($this->groupNum < 15) {
                $this->groupNum = 10;
            } else if($this->groupNum < 21) {
                $this->groupNum = 15;
            } else if($this->groupNum < 28) {
                $this->groupNum = 21;
            } else if($this->groupNum < 36) {
                $this->groupNum = 28;
            } else if($this->groupNum < 45) {
                $this->groupNum = 36;
            } else if($this->groupNum < 55) {
                $this->groupNum = 45;
            } else if($this->groupNum < 66) {
                $this->groupNum = 55;
            } else if($this->groupNum < 78) {
                $this->groupNum = 66;
            } else if($this->groupNum < 91) {
                $this->groupNum = 78;
            } else if($this->groupNum < 105) {
                $this->groupNum = 91;
            } else if($this->groupNum < 120) {
                $this->groupNum = 105;
            } else if($this->groupNum < 136) {
                $this->groupNum = 120;
            } else if($this->groupNum < 153) {
                $this->groupNum = 136;
            } else if($this->groupNum < 171) {
                $this->groupNum = 153;
            } else {
                $this->groupNum = 171;
            }
            //totalStudyTimeからグループの最初の値を引き、グループのステップで割って、グループの何番目かを求める
            $this->position = floor(($totalStudyTime - (150 * $this->groupNum)) / $this->levelAndSteps[$this->groupNum][1]);
            $level = $this->levelAndSteps[$this->groupNum][0] + $this->position;            
        }
        return $level;
    }

    //次のレベルの通算経験値を求め、現在の経験値を差し引く
    public function getNextLevelExp($level, $totalStudyTime) {
        if($level <= 5) {
            return $this->lowLevelSteps[$level];
        } else {
            $totalStudyTime -= 60;
            return ((($this->position + 1) * $this->levelAndSteps[$this->groupNum][1]) + (150 * $this->groupNum)) - $totalStudyTime;
        }
    }

    public function getPercent($level, $totalStudyTime, $nextLevelExp) {
        if($level <= 5) {
            return $totalStudyTime / $nextLevelExp * 100;
        } else {
            return ($this->levelAndSteps[$this->groupNum][1] - $nextLevelExp) / $this->levelAndSteps[$this->groupNum][1] * 100;
        }
    }

    //レベルアップしているかの判定
    public function isLevelUp($level) {
        $user = Auth::user();
        // dd($user);
        if($level > $user->reached_level) {
            return $user->update(['reached_level' => $level]);
        } else {
            return false;
        }
    }
}