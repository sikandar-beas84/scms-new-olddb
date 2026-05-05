
        <!----Footer---->
        <section class="footer">
            <div class="container">
                <div class="footer-row">
                    <div class="footer-col">
                        <h4>About Us</h4>
                        <p>Affiliated to CBSE, New Delhi.Affiliation No. : 2430409. It is the mission of our educational institution to provide a nurturing environment for the students. We aim totransform the youngsters through sound academic education with a distinct worldview.</p>
                    </div>
                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="<?=bs(); ?>">Home</a></li>
                            <li><a href="<?=bs(); ?>about">About</a></li>
                            <li><a href="<?=bs(); ?>course">Course</a></li>
                            <li><a href="<?=bs(); ?>notice-board">Notice
                                    Board</a></li>
                            <li><a href="<?=bs(); ?>contact">Contact</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4>Contact Info</h4>
                        <h5
                            class="text-uppercase mb-4 font-weight-bold text-warning"></h5>
                        <p><i class="fas fa-home mr-3"></i> Vill - Chandua, P.O. - Kanchrapara, Beside Kalyani-Barrackpore Expressway, North 24 Parganas,PIN - 743145, West Bengal</p>
                        <p><i class="fas fa-envelope mr-3"></i> gpskanchrapara@gmail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> + 91 9073112222</p>
                        <!-- <p><i class="fas fa-print mr-3"></i> + 91 987 654
                            3211</p> -->
                    </div>
                    <div class="footer-col">
                        <h4>Follow Us</h4>
                        <div class="social-links">
                            <a href="#"><i
                                    class="fab fa-facebook text-white mr-4"></i></a>
                            <a href="#"><i
                                    class="fab fa-twitch text-white mr-4"></i></a>
                            <a href="#"><i
                                    class="fab fa-instagram text-white mr-4"></i></a>
                            <a href="#"><i
                                    class="fab fa-linkedin text-white mr-4"></i></a>
                        </div>
                    </div>
                </div>
                <hr>
                <p class="mb-0">© 2024 All Rights Reserved.</p>
            </div>
        </section>

        <!---Javascript for toggole menu--->
        <script>
        var navLinks = document.getElementById("navLinks");

        function showMenu() {
            navLinks.style.right = "0";
        }

        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>

    </body>
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.js-slider').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            arrows: true,
            slidesToShow: 2, // Default to 2 slides on desktop
            centerPadding: '20px',
            responsive: [
                {
                    breakpoint: 768, // Mobile screen width (768px or less)
                    settings: {
                        slidesToShow: 1, // Show 1 slide on mobile
                    }
                },
                {
                    breakpoint: 1024, // Tablet and small desktops (1024px or less)
                    settings: {
                        slidesToShow: 2, // Show 2 slides on tablets and desktops
                    }
                }
            ]
        });
    });
</script>


</html>