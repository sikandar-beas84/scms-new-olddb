<!DOCTYPE html>
<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .principal-section {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            padding: 40px 0;
        }
        
        .message-container {
            position: relative;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
        }
        
        .message-header {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .message-content p {
            color: #34495e;
            line-height: 1.8;
            margin-bottom: 20px;
            text-align: justify;
        }
        
        .quote-highlight {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }

        .principal-profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .principal-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid #3498db;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .principal-details {
            margin-top: 15px;
        }

        .principal-name {
            color: #2c3e50;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .principal-designation {
            color: #7f8c8d;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .principal-qualification {
            color: #95a5a6;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <section class="principal-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="message-container">
                        <h1 class="message-header text-center mb-4">Principle Desk</h1>
                        
                        <div class="principal-profile">
                            <img src="<?=bs();?>assets/prin.jpg" alt="Principal" class="principal-image">
                            <div class="principal-details">
                                <h2 class="principal-name">Saikat Chakravorty</h2>
                                <!--<div class="principal-designation">Principal</div>-->
                                <!--<div class="principal-qualification">Ph.D. in Education, M.Ed.</div>-->
                            </div>
                        </div>

                        <div class="message-content">
                            <p>School education lays the foundation for the future of the student and ensures a stable, successful and satisfied life. The <strong>Gyanjyoti Public School</strong> is well aware of the importance and significance of different stages of a student's life and, keeping in mind all these, we adhere to the latest NEP - 2020. Therefore, the activities of the school are planned to identify and nurture their inherent talents. The school puts equal emphasis on Foundational Literacy and Numeracy for all our young learners.</p>
    
                            <p>The period from birth to eight years old is one of remarkable brain development for children and represents a crucial window for opportunity for education. We believe Early Childhood Care and Education (ECCE) that is truly inclusive, and is much more than just preparation for primary school. Teaching and learning process is mainly child-centered and targets to prepare every individual for their career and to acquire adequate life skills.</p>
                            
                            <p>The school activities are planned and prepared meticulously, giving equal importance to academics, co-curricular and extra-curricular activities. These activities are strategically implemented to ensure the overall development of the student. The school is well equipped with state-of-the-art facilities and an excellent infrastructure which provides an ideal and safe environment for teaching and learning.</p>
                            
                            <p>Experiential Learning, Creative Learning, and Hands-on activity are some of our methods and approaches to foster the teaching-learning process to make our learners competent and proficient in all aspects of life. I feel proud to express that the school is expected to perform extremely well in all the aspects to ensure academic and human excellence.</p>
                            
                            <p>I strongly believe that the true education should instill knowledge, creativity, tradition, and culture among the children. The purpose of education is not just to produce academicians but also to develop humane and sensitive citizens.</p>
                            
                            <p>The clear vision of the management, the systematic approach, and implementation of the activities by the administration, commitment and dedication of the teaching and non-teaching staff, cooperation of parents, and the hard work of the students, together will ensure to brand the Gyanjyoti Public School as a center of academic excellence.</p>
                            
                            <p><strong>Gyanjyoti</strong> means enlightenment of knowledge. Our journey towards excellence continues by enlightening the vast world of knowledge. With best regards, I hope, with our collective endeavor, we shall reach our goal with unique and universal possibilities in the forthcoming days.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>