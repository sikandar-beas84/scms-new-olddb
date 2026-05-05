<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="../../kit.fontawesome.com/e6b8371d90.js"
            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?=bs();?>assets/font-end/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&amp;display=swap"
            rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
            <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> <!-- Include Font Awesome -->
            
        <title>Gyanjyoti Public School - <?=$page_title; ?></title>
    </head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <body>
        <style>
        nav svg {
            display: none;
        }
        @media only screen and (max-width: 900px) {
        
            .nav-links ul li a {
                text-decoration: none;
                color: #ffffff;
                font-size: 13px;
                font-weight: 600;
                padding: 0;
                border: 0;
            }
            .services-box07 {
                background: linear-gradient(to bottom, #424242b5, #000000bf);
                padding: 35px;
                transition: 0.3s;
                border-radius: 10px;
                /* margin-left: 64%; */
                height: auto;
            }
            .services-box07 {
                /* margin-top: 200px; */
                height: 410px;
                width: auto;
                margin-left: 0;
            }
            
            .about-col {
                width: 100% !important;
            }
            .contact-us{
                width: 100% !important;
            }
            nav svg {
                display: block !important;
            }
        }
</style>
        <?php if($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '' || $this->uri->segment(1) == 'login'): ?>
        <!----Header---->
        <section class="header">
            <nav>
                <a href="#"><img src="<?=bs();?>assets/font-end/images/logo.png" alt="Logo"></a>

                <div class="nav-links" id="navLinks">
                    <i class="fa fa-times" onclick="hideMenu()"></i>

                    <ul>
                        <li><a href="<?=bs();?>">HOME</a></li>
                        <li><a href="<?=bs();?>about">ABOUT</a></li>
                        <li><a href="<?=bs();?>course">COURSE</a></li>
                        <li><a href="<?=bs();?>page/principalDesk">PRINCIPLE DESK</a></li>
                                    <li><a href="<?=bs();?>notice-board">NOTICE BOARD</a></li>

                        <li><a href="<?=bs();?>contact">CONTACT</a></li>
                        <?php if(empty($this->session->userdata('user_id'))){ ?>
                            <li><a href="<?=bs();?>login" class="login-btn">LOGIN</a></li>
                        <?php }else{ ?>
                            <li><a href="<?=bs();?>dashboard" class="login-btn">Dashboard</a></li>
                        <?php } ?>
                        <!-- <li><a href="#">HOME</a></li>
                    <li><a href="#">ABOUT</a></li>
                    <li><a href="#">COURSE</a></li>
                    <li><a href="#">BLOG</a></li>
                    <li><a href="#">CONTACT</a></li> -->
                    </ul>
                </div>
                <!--<i class="fa fa-bars" onclick="showMenu()"></i>-->
                <svg  onclick="showMenu()" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </nav>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="text-box">
                        <!-- <h1>Gyanjyoti Public School</h1> -->
                        <!-- <p>It is the mission of our educational institution to provide a nurturing environment for the students. <br>We aim to transform the youngsters through sound academic education with a distinct worldview.</p>
                        <a href="#" class="hero-btn">Visit Us To Know More</a> -->
                    </div>
                </div>
            </div>

        </section>
        <?php  else: ?>
                <!----Header---->
                <section class="sub-header">
                    <nav>
                        <a href="#"><img src="<?=bs();?>assets/font-end/images/logo.png" alt="Logo"></a>

                        <div class="nav-links" id="navLinks">
                            <i class="fa fa-times" onclick="hideMenu()"></i>

                            <ul>
                                <li><a href="<?=bs();?>">HOME</a></li>
                                <li><a href="<?=bs();?>about">ABOUT</a></li>
                                <li><a href="<?=bs();?>course">COURSE</a></li>
                                <li><a href="<?=bs();?>page/principalDesk">PRINCIPLE DESK</a></li>
                                <li><a href="<?=bs();?>notice-board">NOTICE BOARD</a></li>
                                <li><a href="<?=bs();?>contact">CONTACT</a></li>
                                <!--<li><a href="<?=bs();?>login" class="login-btn">LOGIN</a></li>-->
                                 <?php if(empty($this->session->userdata('user_id'))){ ?>
                                    <li><a href="<?=bs();?>login" class="login-btn">LOGIN</a></li>
                                <?php }else{ ?>
                                    <li><a href="<?=bs();?>dashboard" class="login-btn">Dashboard</a></li>
                                <?php } ?>
                                
                            </ul>
                        </div>
                        <!--<i class="fa fa-bars" onclick="showMenu()"></i>-->
                        <svg  onclick="showMenu()" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>

                    </nav>

                    <div class="blog-text-box">
                        <h1><?=$page_title; ?></h1>
                    </div>
                </section>
        <?php  endif; ?>
        <!-- Add this in the head section -->
<?php 
        $messages = $this->Generalmodel->getDataWhere('content',['id'=>3]);
        
?>
<!-- Add this right after the nav section -->
<div class="scrolling-messages">
    <div class="marquee">
        <span id="scroll-content">
            <?=$messages[0]->body; ?>
        </span>
    </div>
</div>

<style>
/* Scrolling Messages Styles */
.scrolling-messages {
    background: #f1f1f1;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.marquee {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
}

.marquee span {
    display: inline-block;
    animation: scroll-left 20s linear infinite;
    color: #333;
    font-weight: 500;
}

@keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 500px;
    width: 90%;
    z-index: 1000;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-group textarea {
    height: 100px;
    resize: vertical;
}

.submit-btn {
    background: #0066cc;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.submit-btn:hover {
    background: #0052a3;
}
.modal-content {
    position: relative;
}

.close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    color: #666;
    z-index: 1010;
    background: #fff;
}

.close-icon:hover {
    color: #333;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
// Add this to your existing JavaScript file or create a new one
document.addEventListener('DOMContentLoaded', function() {
    // Function to update scrolling messages
    // function updateScrollingMessages(messages) {
    //     const scrollContent = document.getElementById('scroll-content');
    //     scrollContent.innerHTML = messages.join(' &bull; ');
    // }

    // Initialize with some example messages
    // const initialMessages = [
       
    // ];
    // updateScrollingMessages(initialMessages);

    // Handle notice form submission
    const noticeForm = document.getElementById('notice-form');
    noticeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Add your AJAX call here to submit the form data to your backend
        // Example:
        /*
        fetch('/api/notices', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle success
            closeModal();
            // Refresh notices list
        })
        .catch(error => {
            console.error('Error:', error);
        });
        */
    });
});
</script>
