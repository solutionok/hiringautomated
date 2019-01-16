@extends('layouts.front')
@section('content')
<!-- Masthead -->
<header class="masthead text-center" style="height: 600px;">
    <div class="overlay">
        
    </div>
<!--    <div class="container">
        
        <h1>Best Online Interview Software</h1>
        <h1>It now allows business users to conduct technical interviews. </h1>
        <h1>Using 'Hiring Automated'</h1>
        <p>
            <a class="demo-btn">REQUEST DEMO</a>
        </p>
    </div>-->
</header>

<!-- Process Grid -->
<section class="process text-center">
    <h1>Simplify Your Recruitment Process</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p>
                    <img src="/assets/images/front-process-1.png">
                </p>
                <h4>
                    Cut Early Stage Screening Time By Up To 80%
                </h4>
            </div>
            <div class="col-md-3">
                <p>
                    <img src="/assets/images/front-process-2.png">
                </p>
                <h4>
                    Replace Time Consuming Early Stage Interviews
                </h4>
            </div>
            <div class="col-md-3">
                <p>
                    <img src="/assets/images/front-process-3.png">
                </p>
                <h4>
                    Reduce Recruitment Lifecycle & Costs By 50%
                </h4>
            </div>
            <div class="col-md-3">
                <p>
                    <img src="/assets/images/front-process-4.png">
                </p>
                <h4>
                    Establish More Candidate Focused Recruitment Process
                </h4>
            </div>
        </div>
    </div>
</section>

<!-- Image Showcases -->
<section class="summary">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7">
                <h2>Smarter, Faster Recruitment</h2>
                <p style="font-size: 1.3em;">
                    Video interviewing from Hiringautomated makes panellists to replicate a live interview by replacing the early-stage phone, Skype or face-to-face interviews. Panellists and candidates are not online at the same time. There is no more scheduling of interviews while trying to fix time zone restriction. It has a set of simple screening questions that makes the panellist identify the candidates that meet their criteria almost immediately thus selecting the most suitable. 
                </p>
            </div>
            <div class="col-sm-5">
                <img src="/assets/images/summary.jpg" >
            </div>
        </div>
    </div>
</section>

<!-- Thumbs Grid -->
<section class="thumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="/assets/images/thumbs-1.jpg">
            </div>
            <div class="col-md-3">
                <img src="/assets/images/thumbs-2.jpg">
            </div>
            <div class="col-md-3">
                <img src="/assets/images/thumbs-3.jpg">
            </div>
            <div class="col-md-3">
                <img src="/assets/images/thumbs-4.jpg">
            </div>
        </div>
    </div>
</section>


<!-- testimonials Grid -->
<section class="testimonials">
    <div class="container">
        <h3>testimonials</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="item">
                    <p>
                        <img src="/assets/images/fifthapps.JPG">
                        <span class="name">
                            Khmaiss Ahmed
                        </span>
                        <span class="job">CEO, Fifthapps, fifthapps.com</span>
                    </p>
                    <blockquote>
                     I have embedded HiringAutomated Application in the Career section of my company’s website so that along with the CV, candidates can also upload a quick interview which enables me to check their subject knowledge.
                    </blockquote>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item">
                    <p>
                        <img src="/assets/images/shewtasingh.jpg">
                        <span class="name">
                            Shweta Singh
                        </span>
                        <span class="job"> Director, Competent Chase</span>
                    </p>
                    <blockquote>
                    I run Competent Chase where I prepare candidates as per the requirement of the jobs. HiringAutomated allows me to conduct and record mock interviews which I analyze later by viewing the recorded interviews and plan accordingly. They learn how to be natural and calm during an interview. HiringAutomated help candidates in confidence building which is one of the major factors for selection.

                    </blockquote>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item">
                    <p>
                        <img src="/assets/images/ragatutions.jpg">
                        <span class="name">
                            Sreelakshmi Bodapadu
                        </span>
                        <span class="job">Director (Operations), Raga Tutuion, ragatuition.com</span>
                    </p>
                    <blockquote>
                    It helps me in shortlisting the tutors based on their communication, skills and subject knowledge. This application provides me with a ready database of tutors with their CV and videos which enables me to fulfill the parent’s demand precisely.
                    </blockquote>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item">
                    <p>
                        <img src="/assets/images/xlri.jpg">
                        <span class="name">
                            XLRI
                        </span>
                        <span class="job">Placement Department</span>
                    </p>
                    
                    <blockquote>We had been looking for an application so that our students could have a practice interview before facing the placement interview. This application is exactly what we were looking for, we can create the interview based on our requirements, students can take it anytime as per their convenience and assessors can provide feedback for each question as well as for the complete interview. This would surely help our students to face the placement interviews.</blockquote>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.onload = function(){
        
//var v = document.getElementsByTagName('video')[0];
//v.autoplay = true;
//v.load();
//;
    }
</script>
@endsection