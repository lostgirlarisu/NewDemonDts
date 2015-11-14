<?php

namespace skill2010
{
	//基础抹消率
	$offset_rate2010=40;
	//音感技能每级加成率
	$rateup2010=10;
	
	function init() 
	{
		define('MOD_SKILL2010_INFO','club;');
		eval(import_module('clubbase'));
		$clubskillname[2010] = '中和';
	}
	
	function acquire2010(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2010(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2010(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return 1;
	}
	
	function skill_onload_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加载入一个人物时的动作
		$chprocess($pa);
	}
	
	function skill_onsave_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加保存一个人物时的动作
		$chprocess($pa);
	}
	
	function get_offset_rate(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//获得当前的抵消几率
		eval(import_module('skill2010'));
		
		$skill2003_lv=\skillbase\skill_getvalue(2003,'lvl',$pa);
		return $offset_rate2010+$rateup2010*$skill2003_lv;
	}
	
	function addnoise($where, $typ, $pid1 = -1, $pid2 = -1)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','skill2010','logger'));
		if(\skillbase\skill_query(2010,$pa) && check_unlocked2010($pa)){
			$rand_dice=rand(1,100);
			if ($rand_dice<=get_offset_rate()){
				$log.="你唱出了特殊频率的歌曲抵消了战斗所发出的声响！<br>";
				return;
			}else{
				$log.="你尝试唱出特殊频率的歌曲来抵消战斗所发出的声响，但是却没有成功！<br>";
				$chprocess($where, $typ, $pid1, $pid2);
				return;
			}
		}else{
			$chprocess($where, $typ, $pid1, $pid2);
		}
	}
	
	function deathnews(&$pa, &$pd)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','skill2010','logger'));
		if(\skillbase\skill_query(2010,$pa) && check_unlocked2010($pa)){
			if ($rand_dice<=get_offset_rate()){
				$log.="你唱出了特殊频率的歌曲干扰了敌人的死讯！<br>";
		
				eval(import_module('sys','map','player'));
				$lwname = $typeinfo [$pd['type']] . ' ' . $pd['name'];
				$lstwd = \player\get_player_lastword($pd);
				$db->query ( "INSERT INTO {$tablepre}chat (type,`time`,send,recv,msg) VALUES ('3','$now','$lwname','地点不明','$lstwd')" );
				if ($pd['sourceless']) $x=''; else $x=$pa['name'];
				addnews ( $now, 'death' . $pd['state'], $pd['name'], $pd['type'], $x , $pa['attackwith'], $lstwd );
				return;
			}else{
				$log.="你尝试唱出特殊频率的歌曲来干扰了敌人的死讯，但是却没有成功！<br>";
				$chprocess($pa, $pd);
			}
		}else{
			$chprocess($pa, $pd);
		}
	}
}

?>
