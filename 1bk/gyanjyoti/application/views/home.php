<style>
.notice-date {
    margin-bottom: 10px;
    font-weight: bold;
    color: #666;
}

.notice-text {
    margin-top: 5px;
}

.services-box07 {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.notice {
  background: #e6e6e6;
  border-radius: 10px;
  text-align: initial;
  padding: 10px;
  margin-top: 10px;
}
.notice-text {
  color: #000 !important;
  padding: 0 !important;
}
.services-box07 {
  overflow: auto;
}
</style>
<section class="banner row">
   <?php foreach($banner as $k=>$v){ 
    if($v->image){
    ?>
    <div class="slide <?= $K==0 ?'active':'';?>">
        <img src="<?=bs(); ?>assets/uploads/banner/<?= jd($v->image)[0] ?>" alt="<?=$V->title; ?>">
    </div>
  <?php }} ?>


  <?= $notis = $this->Generalmodel->getDataWhere('content',['id'=>2]); ?>
<!-- Notice Board Pop-up Modal -->
<!-- Notice Board Pop-up Modal -->
<div id="notice-modal" class="modal">
    <div class="modal-content">
        <svg class="close-icon" onclick="closeModal()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        <?php $notisFile = $notis[0]->file ? jd($notis[0]->file)[0] : '';  ?>
        <div id="notice-content"></div> 
    </div>
</div>
  <button class="slider-arrow slider-prev">❮</button>
  <button class="slider-arrow slider-next">❯</button>
  
  <div class="slider-controls">
    <button class="slider-dot active"></button>
    <button class="slider-dot"></button>
    <button class="slider-dot"></button>
  </div>
</section>
        <!----Course---->
        <section class="course row">
            <div class="col-md-6">
                <h1>Courses We Offer</h1>
                <p>We offer a variety of courses designed to help students achieve academic success and personal growth.</p>
                <div class="row">
                    <div class="course-col">
                        <h3>Intermediate</h3>
                        <p>Our Intermediate course builds a strong foundation across core subjects, preparing students for advanced studies and future career paths.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="services-box07">
                     <h3>Notice Board</h3>
                    <div class="">
                        <?php foreach($notice_board as $k => $v) { ?>
                        <div class="notice">
                        <div class="notice-date">
                                <span><?= date('F j, Y', strtotime($v->notice_date)); ?></span>
                            </div>
                            <h4><?= $v->notice_title; ?></h4>
                            <p class="notice-text">
                                <?= $v->description; ?>
                            </p>
                        </div>
                        <?php } ?>
                        <a href="<?=bs();?>notice-board" style="color: red;text-decoration: navajowhite;">Read More</a>
                    </div>
                </div>
            </div>
        </section>

        <!----Campus---->
        <section class="campus">
    <h1>Our School Campuses</h1>
    <p>Explore our beautiful campuses, each offering a unique learning environment designed to foster growth and development.</p>

    <div class="row">
        <div class="campus-col">
            <img src="<?=bs();?>assets/font-end/images/img-18.webp" alt="Main Campus">
            <div class="layer">
                <h3>Main Campus</h3>
            </div>
        </div>

        <div class="campus-col">
            <img src="<?=bs();?>assets/font-end/images/img-02.webp" alt="Sports Campus">
            <div class="layer">
                <h3>Sports Campus</h3>
            </div>
        </div>

        <div class="campus-col">
            <img src="<?=bs();?>assets/font-end/images/gal5.jpg" alt="Science and Technology Campus">
            <div class="layer">
                <h3>Science and Technology Campus</h3>
            </div>
        </div>
    </div>
</section>


         <!-- Our Facilities -->
    <section class="facilities">
        <h1>Our Facilities</h1>
        <p>Our school is equipped with top-notch facilities to provide a well-rounded educational experience.</p>
        <div class="row">
            <div class="facilities-col">
                <img src="<?=bs();?>assets/font-end/images/library.png" alt="Library">
                <h3>World-Class Library</h3>
                <p>Our library offers extensive resources, from books to digital materials, providing students with a quiet and supportive environment for learning and research.</p>
            </div>

            <div class="facilities-col">
                <img src="<?=bs();?>assets/font-end/images/basketball.png" alt="Play Ground">
                <h3>Spacious Play Ground</h3>
                <p>Our large playground encourages physical activity and teamwork, offering space for various sports and recreational activities.</p>
            </div>

            <div class="facilities-col">
                <img src="<?=bs();?>assets/font-end/images/cafeteria.png" alt="Cafeteria">
                <h3>Healthy Cafeteria</h3>
                <p>Our cafeteria provides nutritious and delicious meals, ensuring students have the energy they need for a productive school day.</p>
            </div>
        </div>
    </section>

        <!----Testimonials---->
        <!----Testimonials---->
<!----Testimonials---->
<section class="testimonials">
    <h1>What Our Students Say?</h1>
    <p>Our students and their families share their experiences and appreciate the dedication of our teachers and staff.</p>

    <div class="slider-container">
        <div class="js-slider">
            <div class="slider-item">
                <div class="testimonials-col m-1">
                    <img src="<?=bs();?>assets/font-end/images/testimonial2.webp" alt="Antara Roy">
                    <div>
                        <p>My daughter has been studying in this school since Class I. Over the years, the teachers and staff have continuously guided her towards excellence in education.</p>
                        <h3>Antara Roy</h3>
                        <span>Class 2, Green Section</span>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="slider-item">
                <div class="testimonials-col m-1">
                    <img src="<?=bs();?>assets/font-end/images/testimonial1.webp" alt="Diya Paul">
                    <div>
                        <p>Our daughter has been attending this school since Class I. Throughout these years, the teachers and staff have consistently provided outstanding guidance and support for both academic excellence and personal growth.</p>
                        <h3>Diya Paul</h3>
                        <span>Class 1, Red Section</span>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="slider-item">
                <div class="testimonials-col m-1">
                    <img src="<?=bs();?>assets/font-end/images/testimonial3.webp" alt="Aishani Kundu">
                    <div>
                        <p>The teachers and staff have continually supported and guided my child, encouraging her in both academic excellence and personal development. Their dedication has been invaluable to her growth.</p>
                        <h3>Aishani Kundu</h3>
                        <span>Class 1, Green Section</span>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <!-- Repeat the slider items if needed, using updated content as necessary -->
        </div>
    </div>
</section>



<!----Call For Action---->
<section class="cfa">
    <h1>Enroll For Our Various Online Courses<br>Anywhere From The
        World</h1>
    <a href="<?=bs();?>contact" class="hero-btn">CONTACT US</a>
</section>
<script>
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slider-dot');
const prevButton = document.querySelector('.slider-prev');
const nextButton = document.querySelector('.slider-next');
let currentSlide = 0;

function showSlide(index) {
  slides.forEach(slide => slide.classList.remove('active'));
  dots.forEach(dot => dot.classList.remove('active'));
  
  slides[index].classList.add('active');
  dots[index].classList.add('active');
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
}

function prevSlide() {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  showSlide(currentSlide);
}

// Event listeners
nextButton.addEventListener('click', nextSlide);
prevButton.addEventListener('click', prevSlide);

dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    currentSlide = index;
    showSlide(currentSlide);
  });
});

// Auto advance slides every 5 seconds
setInterval(nextSlide, 5000);


// Function to show notice modal
// function showNoticeModal() {
$(document).ready(function() {
    function showNoticeModal() {
        // Get the file URL from PHP (you would assign this dynamically in PHP)
        var fileUrl = "<?php echo base_url(); ?>assets/uploads/content/<?php echo $notisFile; ?>";

        // Check if the file is an image or video based on the file extension
        var fileExtension = fileUrl.split('.').pop().toLowerCase();  // Get file extension in lowercase

        var noticeContent = document.getElementById('notice-content');
        
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
            // If the file is an image, create an <img> element and set the source
            var img = document.createElement('img');
            img.src = fileUrl;
            img.alt = "Notice Image";  // You can add an alt attribute if needed
            img.style.width = '100%';   // Style as needed
            img.style.height = 'auto';  // Style as needed
            noticeContent.innerHTML = ''; // Clear any existing content
            noticeContent.appendChild(img);  // Append the image element
        } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
            // If the file is a video, create a <video> element and set the source
            var video = document.createElement('video');
            video.controls = true;
            video.src = fileUrl;
            video.style.width = '100%';  // Style as needed
            video.style.height = 'auto'; // Style as needed
            noticeContent.innerHTML = ''; // Clear any existing content
            noticeContent.appendChild(video);  // Append the video element
        } else {
            // If the file type is unsupported, show a message or placeholder
            noticeContent.innerHTML = 'Unsupported file type';
        }

        // Show the modal
        document.getElementById('notice-modal').style.display = 'block';
    holdModal('notice-modal');
    }

    // Call this function to show the modal (you can invoke this based on your event)
    showNoticeModal();
});
// }

// Function to close notice modal
function closeModal() {
    document.getElementById('notice-modal').style.display = 'none';
}
</script>
