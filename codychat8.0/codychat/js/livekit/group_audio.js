var liveRoom = null;
var localTracks = [];

let callUsers = new Set();
let callUsersDelay = null;
let calladmin = false;

closeCall = function(e) {
    liveRoom.disconnect();
    liveRoom = null;
    localTracks.forEach(function (track) {
        track.stop();
    });
    localTracks = [];
    $('#vcall_streams').html('');
	if(e == 99){
		 closeIframe();
	}
    window.location.href = 'call_end.php?end=' + e;
}


handleUserJoined = function(participant, track) {
    if (track.kind === 'audio') {
        let player = $(`#video-wrapper-${participant.identity}`);
        if (player.length) {
            player.replaceWith("");
        }

        player = joinPlayer(participant.identity);
        $('#vcall_streams').append(player);

        const mediaElement = track.attach();
        $(`#stream-${participant.identity}`).append(mediaElement);
		
        callUsers.add(participant.identity);

        if (!callUsersDelay) {
            callUsersDelay = setTimeout(() => {
                handleGroupUser(Array.from(callUsers));
                callUsers.clear();
                callUsersDelay = null;
            }, 300);
        }
    }
}

joinStreams = async function() {
    try {
        let response = await $.post("system/action/action_group_call.php", { open_group_call: appcall });
        let result = JSON.parse(response);
        if (result.code !== 1 || !result.data) {
            console.error("Invalid response from server:", result);
            return;
        }
		
        let { appid, appowner, approom, apptoken, appurl } = result.data;
		if(appowner == appuser){
			calladmin = true;
		}

        const grantMic = await micPermission();

        liveRoom = new LivekitClient.Room({
            adaptiveStream: true,
            autoSubscribe: true,
        });

        liveRoom.prepareConnection(appurl, apptoken).then(function() {
            liveRoom.connect(appurl, apptoken).then(function() {
                liveRoom.remoteParticipants.forEach(participant => {

                    participant.trackPublications.forEach(publication => {
                        if (publication.track && publication.track.kind === 'audio') {
                            handleUserJoined(participant, publication.track);
                        }
                    });

                    participant.on(LivekitClient.ParticipantEvent.IsSpeakingChanged, (speaking) => {
                        let volumeIcon = speaking ? 'volume-on.svg' : 'volume-off.svg';
                        $(`#volume-${participant.identity}`).attr('src', `default_images/call/${volumeIcon}`);
                    });

                });

                liveRoom.on(LivekitClient.RoomEvent.TrackSubscribed, (track, publication, participant) => {
                    if (track.kind === 'audio') {
                        handleUserJoined(participant, track);

						participant.on(LivekitClient.ParticipantEvent.IsSpeakingChanged, (speaking) => {
							let volumeIcon = speaking ? 'volume-on.svg' : 'volume-off.svg';
							$(`#volume-${participant.identity}`).attr('src', `default_images/call/${volumeIcon}`);
						});
                    }
                });

                LivekitClient.createLocalTracks({
                    audio: grantMic, video: false
                }).then(function(tracks) {
                    localTracks = tracks;

                    let player = selfAudioPlayer(appuser);
                    $('#vcall_self').append(player).removeClass('vcallhide');

                    if (grantMic) {
                        liveRoom.localParticipant.setMicrophoneEnabled(true);
                    }

                    liveRoom.on('participantDisconnected', function(disconnectedParticipant) {
                        handleUserLeft(disconnectedParticipant.identity);
                    });

                }).catch(function(error) {
                    console.error('Error:', error);
					//closeCall(1);
                });
            }).catch(function(error) {
                console.error('Error:', error);
                //closeCall(1);
            });
        }).catch(function(error) {
            console.error('Error:', error);
			//closeCall(1);
        });

    } catch (error) {
        console.error("Error:", error);
        //closeCall(1);
    }
};

let selfAudioPlayer = (id) => {
    return `<div class="vcall_container" id="video-wrapper-${id}">
                <div class="vcall_player player" id="stream-${id}">
                </div>
            </div>`;
};

let joinPlayer = (id) => {
    return `<div class="call_item lite_olay btable" id="video-wrapper-${id}">
				<div data="${id}" class="callact call_item_avatar bcell_mid">
					<img id="vcall_avatar${id}" src="default_images/misc/holder.png"/>
				</div>
				<div data="${id}" class="callact call_item_name bcell_mid">
					<p id="vcall_u${id}"></p>
					<div  class="vcall_player player" id="stream-${id}">
					</div>
				</div>
				<div onclick="callBan(${id});" class="callactban${id} bcell_mid call_action hidden">
					<i class="fa fa-ban"></i>
				</div>
				<div class="bcell_mid call_mic">
					<img  id="volume-${id}" src="default_images/call/volume-off.svg" />
				</div>
            </div>`;
};

let startStream = async () => {
    await joinStreams();
}

let closeIframe = () => {
    window.parent.postMessage("endCall", window.location.origin);
}

let handleGroupUser = function(ui) {
    if (ui.length === 0){
		return;
	}
    $.ajax({
        url: "system/action/action_group_call.php",
        type: "post",
        cache: false,
        dataType: 'json',
        data: { call_group_user: ui },
        success: function(response) {
            if (response.code !== 0) {
                response.data.forEach(user => {
                    $('#vcall_u' + user.user_id).text(user.user_name);
                    $('#vcall_avatar' + user.user_id).attr('src', user.avatar);
                });
            }
        }
    });
};

let handleUserLeft = (u) => {
    $(`#video-wrapper-${u}`).replaceWith("");
}

let upgradeGroupCall = () => {
    $.post('system/action/action_group_call.php', {
        upgrade_group_call: appcall,
    }, function (response) {
        if (response != 0) {
			closeCall(response);
        }
    });
};

let callBan = (id) => {
    $.post('system/action/action_group_call.php', {
        call_ban: id,
		call_id: appcall,
    }, function (response) {
    });
};

$('#vcall_mic').on('click', async () => {
    localTracks.forEach(function(track) {
        if (track.kind === 'audio') {
            if (track.isMuted) {
                track.unmute();
                liveRoom.localParticipant.setMicrophoneEnabled(true);
                $('#vcall_mic').removeClass('vcall_off');
            } else {
                track.mute();
                liveRoom.localParticipant.setMicrophoneEnabled(false);
                $('#vcall_mic').addClass('vcall_off');
            }
        }
    });
});

$(document).on('click', '.callact', async function () {
	var uact = $(this).attr('data');
	var callactBan = $('.callactban' + uact);
	var callactMute = $('.callactmute' + uact);
	callactMute.toggleClass('hidden');
	if (calladmin) {
		callactBan.toggleClass('hidden');
	}
});

$('#vcall_leave').on('click', async () => {
    await closeCall(99);
})

const micPermission = async () => {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        if (!devices.some(device => device.kind === 'audioinput')) return false;

        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        stream.getTracks().forEach(track => track.stop());
        return true;
    } catch {
        return false;
    }
};

$(document).ready(function() {
    $.ajaxSetup({
        data: { token: utk, cp: curPage }
    });

    startStream();
    groupCallUpgrade = setInterval(upgradeGroupCall, 10000);
    upgradeGroupCall();
});