var liveRoom = null;
var localTracks = [];

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
        let player = $(`#audio-wrapper-${participant.identity}`);
        if (player.length) {
            player.replaceWith("");
        }

        player = joinAudioPlayer(participant.identity);
        $('#vcall_streams').append(player);

        const mediaElement = track.attach();
        $(`#stream-${participant.identity}`).append(mediaElement);

        handleUserName(participant.identity);
    }
}

joinStreams = async function() {
    try {
        let response = await $.post("system/action/action_call.php", { open_call: appcall });
        let result = JSON.parse(response);
        if (result.code !== 1 || !result.data) {
            console.error("Invalid response from server:", result);
            return;
        }
		
        let { appid, approom, apptoken, appurl } = result.data;

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
						
						track.on('volumeChanged', (volume) => {
							let isSpeaking = volume > 0.01;
							let volumeIcon = isSpeaking ? 'volume-on.svg' : 'volume-off.svg';
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
					closeCall(1);
                });
            }).catch(function(error) {
                console.error('Error:', error);
                closeCall(1);
            });
        }).catch(function(error) {
            console.error('Error:', error);
			closeCall(1);
        });

    } catch (error) {
        console.error("Error:", error);
        closeCall(1);
    }
};

let selfAudioPlayer = (id) => {
    return `<div class="vcall_container" id="audio-wrapper-${id}">
                <div class="vcall_player player" id="stream-${id}">
                </div>
            </div>`;
}

let joinAudioPlayer = (id) => {
    return `<div class="vcall_container" id="audio-wrapper-${id}">
                <p class="vcall_user"><img class="vcall_vol" id="volume-${id}" src="default_images/call/volume-off.svg" /><span id="vcall_u${id}"></span></p>
                <div class="vcall_player player vcall_player_join" id="stream-${id}">
                </div>
            </div>`;
}

let startStream = async () => {
    await joinStreams();
}

let closeIframe = () => {
    window.parent.postMessage("endCall", window.location.origin);
}

let handleUserName = (id) => {
    $.post('system/action/action_call.php', {
        call_user: id,
    }, function(response) {
        if (response != 0) {
            $('#vcall_u' + id).text(response);
        }
    });
}

let handleUserLeft = (u) => {
    $(`#audio-wrapper-${u}`).replaceWith("");
    closeCall(99);
}

let upgradeCall = () => {
	$.post('system/action/action_call.php', { 
			upgrade_call: appcall,
		}, function(response) {
			if(response != 0){
				closeCall(response);
			}
	});
}

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
})

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
    callUpgrade = setInterval(upgradeCall, 10000);
    upgradeCall();
});