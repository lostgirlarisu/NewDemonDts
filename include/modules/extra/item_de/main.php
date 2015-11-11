<?php

namespace item_de
{
	function init() 
	{
		eval(import_module('itemmain'));
		$iteminfo['EC']='DEBUG工具';
	}
	
	function itemuse(&$theitem)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player','logger','clubbase','skillbase'));
		
		$itm=&$theitem['itm']; $itmk=&$theitem['itmk'];
		$itme=&$theitem['itme']; $itms=&$theitem['itms']; $itmsk=&$theitem['itmsk'];
		
		if ($itmk=='EC'){
			if ($itm == '亚莉丝的神奇药剂') {
				$log .= "使用了<span class=\"yellow\">$itm</span>。<br>";
				healpotion();
				//\itemmain\itms_reduce($theitem);//这个命令是使道具使用后减少耐久的基础
				return;
			} elseif ($itm == '亚莉丝的升级药剂') {
				$log .= "使用了<span class=\"yellow\">$itm</span>。<br>";
				lvuppotion();
				return;
			} elseif ($itm == '调试技能学习书'){
				\skillbase\skill_lost(2000);
				\skillbase\skill_acquire(2000);
				return;
			} elseif ($itm == '转职工具'){
        \clubbase\club_lost();
        //\clubbase\club_acquire(201);
        //\itemmain\itms_reduce($theitem);//这个命令是使道具使用后减少耐久的基础
        $log .="你使用了{$itm}，失去了原有的觉醒力量，并获得了新的力量。";
        return;
			} elseif ($itm == '调试套装') {
				$itm1='亚莉丝的神奇药剂';$itm2='亚莉丝的升级药剂';$itm3='调试技能学习书';$itm4='转职工具';
				$itmk1=$itmk2=$itmk3=$itmk4='EC';
				$itme1=$itme2=$itme3=$itme4=1;
				$itms1=$itms2=$itms3=$itms4=1;
			}
		}
		$chprocess($theitem);
	}
	
	function healpotion(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('player','logger','wound'));
		$hp=$mhp;
		$sp=$msp;
		$ss=$mss;
		$inf = '';
		$log .= "HP、SP以及歌魂全都恢复了！<br>所有异常状态也消除了！<br>";
		return;
	}
	
	function lvuppotion(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('lvlctl','logger'));
		\lvlctl\getexp(100);
		return;
	}
}

?>
