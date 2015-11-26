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
				//\skillbase\skill_acquire(2017);
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
		}elseif (strpos ( $itmk, 'Y' ) === 0 || strpos ( $itmk, 'Z' ) === 0){
			if ($itm=='觉醒剂试制二型'){
				//$log .= "使用了<span class=\"yellow\">$itm</span>。<br>";
				$log .= "你考虑了一会，<br>把袖子卷了起来，给自己注射了<span class=\"yellow\">{$itm}</span>。<br>";
				awakepotion();
				\itemmain\itms_reduce($theitem);
			} elseif ($itm=='紧急情况指示器'){
				//开启死斗模式的道具
				$duelstate = \gameflow_duel\duel($now,$itm);
				if($duelstate == 50){
					$log .= "<span class=\"yellow\">你使用了{$itm}。</span><br><span class=\"evergreen\">“这里是单向通信，已确实收到岛屿不再适合用于实验计划的紧急情况指示。即将疏散撤离战场上的所有相关人员……”</span><br>
					<span class=\"evergreen\">所有的NPC似乎都离开战场了。但是只有逃杀实验计划并未终止，接下来的杀戮已经无法避免……</span><br>";
					\itemmain\itms_reduce($theitem);
				}elseif($duelstate == 51){
					$log .= "你使用了<span class=\"yellow\">{$itm}</span>，<br><span class=\"evergreen\">指示器响起了电子音，“指示已经执行……请勿重复发信……”</span><br>";
				} else {
					$log .= "你使用了<span class=\"yellow\">{$itm}</span>，不过什么反应也没有。<br><span class=\"evergreen\">看来发信的时机不对的样子。</span><br>";
				}
				return;
			} elseif ($itm=='霜雪之心'){
				if($wepk=='WN'){
					$log .="你尝试使用{$itm}，但是什么事也没有发生。<br>";
				}else{
					$log .="{$itm}好像受到了某种引力一样，融进了你手持的武器里！<br>";
					$wepsk=str_replace('i','',$wepsk);
					$wepsk.='i';
					\itemmain\itms_reduce($theitem);
				}
			} else{
				//提示纸条类道具
				onlynote($itm);
				//NPC召唤类道具(注意导入的数据)
				addnpcitem($theitem);
				//结局触发类道具
				endingitem($itm);
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
	
	function awakepotion(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//觉醒剂
		eval(import_module('player','logger'));
		$deathdice = rand ( 1, 100 );
		if ($deathdice <= 5 || $club == 0) {
			$moedice = rand (1,100);
			if($club ==0) $moedice+=20;
			if(($wp<250)&&($wk<250)&&($wg<250)&&($wc<250)&&($wd<250)&&($wf<250)){
				$log .= '你突然感觉到一种不可思议的力量贯通全身！<br>';
				$wp = $wk = $wg = $wc = $wd = $wf = 250;
				if($moedice>=95){
					$log .= '你突然觉醒成了走路萌物！<br>';
        	\clubbase\club_lost();
        	\clubbase\club_acquire(17);
				}
			}else{
				$log .= '你突然感觉到一种不可思议的力量贯通全身,但是不一会儿便消散去了大部分。<br>';
				$wp = floor($wp*1.1);
				$wk = floor($wk*1.1);
				$wg = floor($wg*1.1);
				$wc = floor($wc*1.1);
				$wd = floor($wd*1.1);
				$wf = floor($wf*1.1);
				if($moedice>=75){
					$log .= '你突然觉醒成了走路萌物！<br>';
        	\clubbase\club_lost();
        	\clubbase\club_acquire(17);
				}
			}
			
		} elseif($deathdice > 35) {
			$log .= '你突然感觉到强烈的痛苦伴随着一种不可思议的力量贯通全身！<br>
			持续了一段时间的煎熬结束了，你发现自己并没有什么显著变化。';
		} else {
			$log .= '你突然感觉到强烈的痛苦伴随着一种不可思议的力量贯通全身！<br>
			持续了一段时间的煎熬结束了，你感觉十分虚弱。';
			$hp=1;
			$sp=0;
		}
	return;
	}
	
	function onlynote(&$itm){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger'));
		//只有提示语的道具都放这里
		if ($itm=='北大路的便笺'){
			$log .= '你读着便笺上的内容：“……看得出来，伍长一直觊觎着这个叫做九系统的东西。<br>
			……为了避免本次任务节外生枝，不能让他知道潜艇秘密搬运了九系统的其中一台……”<br>';
		} elseif($itm=='九老人的手记卷轴'){
			$log .= '你读了手记，了解到了九系统的一些秘密以及重启指令。<br>
			据手记描述，九系统重启的话会发生超光加速……关于之后会导致什么事情发生的描述文字被涂抹掉了。”<br>';
		}	elseif($itm=='破烂的日记'){
			$log .= '你翻开了日记，但是前面的字迹全部都莫名其妙的无法认知，只有最后一页的可以理解：<br>
			“我已经不记得这是第多少次了，就连我本人的记忆也因为重复次数的过多导致开始消失了……或许这个计划真的是不可逆转的，但是我已经没有退路了。”<br>';
		}
		return;
	}
	
	function endingitem(&$itm){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger','sys','player'));
		//用于触发结局的道具都放这里
		if ($itm=='九系统的重启方法'){
			//LOOP结局
			if($pls!=23){
				$log .="在考虑如何实施之前，近距离接触到九系统是必要的！<br>";			
			}else{
				$state = 6;
				$url = 'end.php';
				\sys\gameover ( $now, 'end11', $name );
			}
		}
	}
	
	function addnpcitem(&$theitem){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','player','itemmain','logger'));
		//召唤NPC的道具都放这里
		//注意该函数与其他函数的引用数据的区别！
		$itm=&$theitem['itm']; $itmk=&$theitem['itmk'];
		$itme=&$theitem['itme']; $itms=&$theitem['itms']; $itmsk=&$theitem['itmsk'];
		
		if ($itm == '书库联结') {
			if (in_array($gametype,Array(10,11,12,13,14)))
			{
				$log.="你使用了{$itm}，但是什么也没有发生（当前游戏模式下不允许PVE）。<br>";
				return;
			}
			$log .= "你启动了{$itm}，<br>“资料重载……具现率25%……40%……70%……95%……具现完成。确认资讯，旧具现体损坏率70%以上，判断废弃。”<br>
			“全面出力处理完成，沟通界面解放。”<br>“姆呼呼呼……我和整个书库界面一起在灵子研究中心等着你们哦。<br>”";
			addnpc ( 13, 1,1);
			addnews ($now , 'wikigirl', $name);
			\itemmain\itms_reduce($theitem);
			return;
		}elseif ($itm == '测试NPC召唤器') {
			if (in_array($gametype,Array(10,11,12,13,14)))
			{
				$log.="你使用了{$itm}，但是什么也没有发生（当前游戏模式下不允许PVE）。<br>";
				return;
			}
			$test = 1;
			if($test){
				$log .= "你启动了{$itm}，近期某个开发测试中的NPC被你召唤出来了！<br>";
				addnpc ( 13, 0,1);
				addnews ($now , 'testnpc', $name);
			}else{
				$log .= "你启动了{$itm}，但是由于最近并没有什么开发测试中的NPC，所以什么事都没有发生。<br>";
			}
			\itemmain\itms_reduce($theitem);
			return;
		}elseif ($itm == '恶魔晶状体') {
			if (in_array($gametype,Array(10,11,12,13,14)))
			{
				$log.="你使用了{$itm}，但是什么也没有发生（当前游戏模式下不允许PVE）。<br>";
				return;
			}
			$rollnum=rand(1,10);
			if ($rollnum <= 2){
				$log .= '你不顾后果召唤了某个深渊灾厄，<br>现在后悔也来不及了。<br>';
				$npcno=rand(0,4);
				addnpc ( 17, $npcno,1);
				addnews ($now , 'demon2', $name);
			}else{
				$log .= '你不顾后果企图召唤深渊灾厄，<br>但是什么事也没有发生。<br>';
			}
			\itemmain\itms_reduce($theitem);
			return;
		}elseif ($itm == '可疑的发信器') {
			if (in_array($gametype,Array(10,11,12,13,14)))
			{
				$log.="你使用了{$itm}，但是什么也没有发生（当前游戏模式下不允许PVE）。<br>";
				return;
			}
			$log .= '你启动了发信器，<br>也许什么人已经迅速定位了你的位置并且正在前来，<br>
			搜寻打倒他们还是赶紧逃跑？赶紧作出抉择吧！<br>';
			addnpc ( 16, 0,1);
			addnpc ( 16, 1,1);
			$ex_add=rand(1,10);
			if ($ex_add <= 5) addnpc ( 16, 2,1);
			addnews ($now , 'ghost9', $name);
			\itemmain\itms_reduce($theitem);
			return;
		}
	}
	
	function parse_news($news, $hour, $min, $sec, $a, $b, $c, $d, $e){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','player'));
		//召唤NPC发布的新闻接管
		if($news == 'wikigirl')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了书库联结装置，使得全面出力的书库娘具现到了灵子研究中心！</span><br>\n";
		if($news == 'ghost9')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了可疑的发信器，使得什么可疑人物加入了战场！</span><br>\n";
		if($news == 'testnpc')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}呼唤了一名还处于开发测试阶段NPC！大家可以尝试去挑战！</span><br>\n";
		if($news == 'demon')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}呼唤了玩家脑子一热自荐的为追求个性却完全违背游戏平衡的文案所设计的NPC深渊灾厄！</span><br>\n";
		if($news == 'demon2')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"lime\">{$a}使用了恶魔晶状体，使得什么可怕存在加入了战场！</span><br>\n";
		//使用结局道具的新闻接管
		if($news == 'end11')
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"red\">{$a}重启了九系统，游戏本身的存在消匿在时空尽头了。</span><br>\n";
		return $chprocess($news, $hour, $min, $sec, $a, $b, $c, $d, $e);
	}
}

?>
