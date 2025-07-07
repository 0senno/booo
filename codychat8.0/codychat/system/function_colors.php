<?php
function colorChoice($sel, $type, $min = 1){
	$show_c = '';
	switch($type){
		case 1:
			$c = 'choice';
			break;
		case 2:
			$c = 'user_choice';
			break;
		case 3:
			$c = 'name_choice';
			break;
		default:
			return false;
	}
	for ($n = $min; $n <= 32; $n++) {
		$val = 'bcolor' . $n;
		$back = 'bcback' . $n;
		$add_sel = '';
		if($val == $sel){
			$add_sel = '<i class="fa fa-check bccheck"></i>';
		}
		$show_c .= '<div data="' . $val . '" class="color_switch ' . $c . ' ' . $back . '">' . $add_sel . '</div>';
	}
	return $show_c;
}
function gradChoice($sel, $type, $min = 1){
	$show_c = '';
	switch($type){
		case 1:
			$c = 'choice';
			break;
		case 2:
			$c = 'user_choice';
			break;
		case 3:
			$c = 'name_choice';
			break;
		default:
			return false;
	}
	for ($n = $min; $n <= 40; $n++) {
		$val = 'bgrad' . $n;
		$back = 'backgrad' . $n;
		$add_sel = '';
		if($val == $sel){
			$add_sel = '<i class="fa fa-check bccheck"></i>';
		}
		$show_c .= '<div data="' . $val . '" class="color_switch ' . $c . ' ' . $back . '">' . $add_sel . '</div>';
	}
	return $show_c;
}
function neonChoice($sel, $type, $min = 1){
	$show_c = '';
	switch($type){
		case 1:
			$c = 'choice';
			break;
		case 2:
			$c = 'user_choice';
			break;
		case 3:
			$c = 'name_choice';
			break;
		default:
			return false;
	}
	for ($n = $min; $n <= 32; $n++) {
		$val = 'bneon' . $n;
		$back = 'bnback' . $n;
		$add_sel = '';
		if($val == $sel){
			$add_sel = '<i class="fa fa-check bccheck"></i>';
		}
		$show_c .= '<div data="' . $val . '" class="color_switch ' . $c . ' ' . $back . '">' . $add_sel . '</div>';
	}
	return $show_c;
}
?>