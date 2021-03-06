<?php

namespace skill2012
{
	function init() 
	{
		define('MOD_SKILL2012_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2012] = '收录';
	}
	
	function acquire2012(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2012(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2012(&$pa)
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

	//在打击准备阶段起作用……大概
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if(\skillbase\skill_query(2012,$pa) && check_unlocked2012($pa)){
			embody2012($pa,$pd,$active);
		}
		//如果对手中收录而死的话跳出打击准备流程，防止发动直死后NPC继续补刀导致覆盖死亡信息
		if(\skillbase\skill_query(2012,$pa) && check_unlocked2012($pa) && $pd['hp']<=0) return;
		$chprocess($pa, $pd, $active);
	}

	function embody2012(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//这里才是技能效果部分
		eval(import_module('logger'));
		$log .= "<span class=\"yellow\">书库娘手往前一推，散发光芒的百科全书朝向你快速翻动着书页！</span><br>
		<span class=\"linen\">“这样的战斗可是超有价值的哦！展开吧！无限书库的写入程式！”</span><br>";
		
		$rand_dice=rand(1,666)*($pa['killnum']+1);
		if($rand_dice>=666){
			//收录致死
			embody_to_death2012($pa,$pd,$active);
			return;
		}else{
			$rand_dice2=rand(1,100);
			if($rand_dice2<=80){
				$log .= "<span class=\"yellow\">书库娘的百科全书散发的光芒竟毫无预兆地聚焦到了你手持的武器上！</span><br>
					<span class=\"linen\">“喵哈哈哈哈！收录到啦！我要赶紧试试效果！”</span><br>
					<span class=\"yellow\">你的武器性质被书库娘收录了！</span><br>";
				$pa['wepk']=$pd['wepk'];	$pa['wepe']=$pd['wepe'];	$pa['wepsk']=$pd['wepsk'];
				if(($pd['weps']==$nosta)||($pd['weps']<=20)){
					$pa['weps']=200;
				}else{
					$pa['weps']=$pd['weps'];
				}
			}else{
				$log .= "<span class=\"yellow\">书库娘的百科全书散发的光芒往四周消散了。</span><br>
					<span class=\"linen\">“呜喵！没收录到！不过不要紧，还有的是机会！”</span><br>";
			}
		}
	}
	
	function embody_to_death2012(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//成为书库的一部分了(死了)
		eval(import_module('logger','attack'));
		
		$log .= "<span class=\"yellow\">书库娘的百科全书散发的光芒把你整个人包覆了！</span><br>
		<span class=\"linen\">“哦哦哦！竟然整个都收录啦！超Lucky～”</span><br>
		<span class=\"yellow\">你被收录了！</span><br>";
		$pa['killnum'] ++;
		$pd['hp']=0;
		$pd['deathmark']=100;
		//\attack\player_kill_enemy($pa, $pd, $active);//HP为0时自带了判定，不用写这句了
	}
	
	function parse_news($news, $hour, $min, $sec, $a, $b, $c, $d, $e)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player'));
		
		if($news == 'death100') {
			$dname = $typeinfo[$b].' '.$a;
			if(!$e)
				$e0="<span class=\"yellow\">【{$dname} 什么都没说就死去了】</span><br>\n";
			else  $e0="<span class=\"yellow\">【{$dname}：“{$e}”】</span><br>\n";
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"yellow\">$a</span>被<span class=\"red\">$c</span>的深渊书库收录而存在抹消{$e0}";
		}
		return $chprocess($news, $hour, $min, $sec, $a, $b, $c, $d, $e);
	}

	function strike(&$pa,&$pd,$active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//理由类似于strike_prepare()的接管
		if(\skillbase\skill_query(2012,$pa) && check_unlocked2012($pa) && $pd['hp']<=0){
			return;
		}
		$chprocess($pa, $pd, $active);
	}
}

?>
