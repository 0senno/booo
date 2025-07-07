<?php if($boom['call_type'] == 1){ ?>
<iframe id="call_frame" allow="camera; microphone;" class="biframe callsize videosize" src="call.php"></iframe>
<?php } ?>
<?php if($boom['call_type'] == 2){ ?>
<iframe id="call_frame" class="biframe callsize audiosize" src="call.php"></iframe>
<?php } ?>