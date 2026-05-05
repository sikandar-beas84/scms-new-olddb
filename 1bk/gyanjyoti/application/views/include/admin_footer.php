</div>
<!--Footer-->
<footer class="footer">
	<div class="container">
		<div class="row align-items-center flex-row-reverse">
			<div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
				<!--<p class="mb-0">Copyright © 2024 <a href="#"> <?= $page_title ?> </a>. -->
                <!-- Developed by <a href="#">Suhrid Sarkar</a> -->
				</p>
			</div>
		</div>
	</div>
</footer>
<!-- End Footer-->

</div>

<!-- Back to top -->
<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>


<!-- Added By Suhrid 05-06-2023 -->

<script>
    var idleTime = 0;
    <?php 
		$user_details = $this->LoginModel->get_user_data('user_masters', $this->session->userdata('user_id'));
		if($user_details->screen_lock == 'Y'){
	?>
    var idleInterval = setInterval(timerIncrement, 60000); // Check every 1 minute
    <?php } ?>
    // Increment the idle time counter
    // function timerIncrement() {
    //     // alert("1");
    //     idleTime++;
    //     if (idleTime >= <?= ($user_details->screen_lock_after_second / 60);?>) { // 15 minutes
    //         window.location.href = '<?php echo site_url('lock_screen'); ?>';
    //     }
    // }

    // Reset the idle time counter on user activity
    $(document).on('mousemove keydown scroll', function() {
        idleTime = 0;
    });
	// script.js
// script.js
$(document).ready(function() {
    function updateTime() {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        let ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // If hours is 0, make it 12

        // Format time as HH:MM:SS AM/PM
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        let timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
        
        // Update the time in the #timeClock div
        $('#timeClock').text(timeString);
    }

    // Update time every second
    setInterval(updateTime, 1000);

    // Initial call to display time immediately
    updateTime();
});

</script>
<script>
    $(document).ready(function() {
        $('#date').datepicker({
            format: 'mm/dd/yyyy', // You can change the format as needed
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
