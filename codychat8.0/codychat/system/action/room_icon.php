<?php
require(__DIR__ . '/../config_session.php');

function addRoomIcon(){
	global $mysqli, $data;
	
	if(!canEditRoom()){
		return boomCode(0);
	}
	$room = roomDetails($data['user_roomid']);
	if(empty($room)){
		return boomCode(0);
	}
	
	ini_set('memory_limit','128M');
	$info = pathinfo($_FILES["file"]["name"]);
	$extension = $info['extension'];

	if(fileError(4)){
		return boomCode(1);
	}

	$file_tumb = "room_icon" . $room["room_id"] . "_" . time() . ".jpg";
	$file_icon = "temporary_room_icon_" . $room["room_id"] . "." . $extension;
	unlinkRoomIcon($file_icon);
	
	if (isImage($extension)){
		$info = getimagesize($_FILES["file"]["tmp_name"]);
		if ($info !== false) {
			$width = $info[0];
			$height = $info[1];
			$type = $info['mime'];
			boomMoveFile('room_icon/' . $file_icon);
			$filepath = 'room_icon/' . $file_tumb;
			$filesource = 'room_icon/' . $file_icon;
			$create = createTumbnail($filesource, $filepath, $type, $width, $height, 200, 200);
			
			if(sourceExist($filepath) && sourceExist($filesource)){
				if (validImageData($filepath)) {
					unlinkRoomIcon($file_icon);
					unlinkRoomIcon($room['room_icon']);
					$mysqli->query("UPDATE boom_rooms SET room_icon = '$file_tumb' WHERE room_id = '{$room['room_id']}'");
					redisUpdateRoom($room['room_id']);
					return boomCode(5, array('data'=> myRoomIcon($file_tumb)));
				}
				else {
					unlinkRoomIcon($file_icon);
					return boomCode(7);
				}
			}
			else {
				unlinkRoomIcon($file_icon);
				return boomCode(7);
			}
		}
		else {
			return boomCode(7);
		}
	}
	else {
		return boomCode(1);
	}
}
function removeRoomIcon(){
	global $mysqli, $data;
	
	if(!canEditRoom()){
		return boomCode(0);
	}
	
	$room = roomDetails($data['user_roomid']);
	if(empty($room)){
		return boomCode(0);
	}
	unlinkRoomIcon($room['room_icon']);
	$mysqli->query("UPDATE boom_rooms SET room_icon = 'default_room.png' WHERE room_id = '{$data['user_roomid']}'");
	redisUpdateRoom($data['user_roomid']);
	return boomCode(1, array('data'=> myRoomIcon('default_room.png')));
}

function staffAddRoomIcon(){
	global $mysqli, $data;
	
	if(!canManageRoom()){
		return boomCode(0);
	}
	
	$r = escape($_POST['staff_add_icon'], true);
	$room = roomDetails($r);
	
	if(empty($room)){
		return boomCode(0);
	}
	
	ini_set('memory_limit','128M');
	$info = pathinfo($_FILES["file"]["name"]);
	$extension = $info['extension'];

	if(fileError(4)){
		return boomCode(1);
	}

	$file_tumb = "room_icon" . $room["room_id"] . "_" . time() . ".jpg";
	$file_icon = "temporary_room_icon_" . $room["room_id"] . "." . $extension;
	unlinkRoomIcon($file_icon);
	
	if (isImage($extension)){
		$info = getimagesize($_FILES["file"]["tmp_name"]);
		if ($info !== false) {
			$width = $info[0];
			$height = $info[1];
			$type = $info['mime'];
			boomMoveFile('room_icon/' . $file_icon);
			$filepath = 'room_icon/' . $file_tumb;
			$filesource = 'room_icon/' . $file_icon;
			$create = createTumbnail($filesource, $filepath, $type, $width, $height, 200, 200);
			
			if(sourceExist($filepath) && sourceExist($filesource)){
				if (validImageData($filepath)) {
					unlinkRoomIcon($file_icon);
					unlinkRoomIcon($room['room_icon']);
					$mysqli->query("UPDATE boom_rooms SET room_icon = '$file_tumb' WHERE room_id = '{$room['room_id']}'");
					redisUpdateRoom($room['room_id']);
					return boomCode(5, array('data'=> myRoomIcon($file_tumb)));
				}
				else {
					unlinkRoomIcon($file_icon);
					return boomCode(7);
				}
			}
			else {
				unlinkRoomIcon($file_icon);
				return boomCode(7);
			}
		}
		else {
			return boomCode(7);
		}
	}
	else {
		return boomCode(1);
	}
}
function staffRemoveRoomIcon(){
	global $mysqli, $data;
	$id = escape($_POST['staff_remove_icon'], true);
	
	if(!canManageRoom()){
		return boomCode(0);
	}
	
	$room = roomDetails($id);
	if(empty($room)){
		return boomCode(0);
	}
	unlinkRoomIcon($room['room_icon']);
	$mysqli->query("UPDATE boom_rooms SET room_icon = 'default_room.png' WHERE room_id = '$id'");
	redisUpdateRoom($id);
	return boomCode(1, array('data'=> myRoomIcon('default_room.png')));
}

// end of functions

if (isset($_FILES["file"], $_POST['add_icon'])){
	echo addRoomIcon();
	die();
}
if (isset($_FILES["file"], $_POST['staff_add_icon'])){
	echo staffAddRoomIcon();
	die();
}
if(isset($_POST['remove_icon'])){
	echo removeRoomIcon();
	die();
}
if(isset($_POST['staff_remove_icon'])){
	echo staffRemoveRoomIcon();
	die();
}
die();
?> 