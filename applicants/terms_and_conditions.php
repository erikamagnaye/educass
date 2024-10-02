
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php' ?>
	<title>Educational Assistance San Antonio </title>
	<link rel="icon" href="assets/img/logo.png" type="image/x-icon"/>   <!-- THIS IS THE CODE TO DISPLAY AN ICON IN THE BROWASER TAB-->
	<link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
      
	<style>
     body{
    background: url('assets/img/saqbound.jpg') no-repeat center center fixed; 
    background-size: cover;
  
}

        .container-login {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Adds a slight white overlay for readability */
            border-radius: 10px;
            padding: 20px;
        }
		.auth-link {
  text-decoration: none;
}
    </style>
</head>
<body >
<?//php include 'templates/loading_screen.php' ?>






	<div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-8">
            <div class="card mb-3 mt-3" style="width: 80%; margin: 0 auto;">
            <div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Educational Assistance</div>
										<div class="card-tools">
											<button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
												<i class="fa fa-print"></i>
												Print 
											</button>
                                            <button class="btn btn-danger btn-border btn-round btn-sm" onclick="window.location ='createacc.php'">
												<i class="fa fa-chevron-left"></i>
												Back
											</button>
										</div>
									</div>
								</div>
                <div class="card-body" id="printThis">
                <div class="d-flex flex-wrap justify-content-around" style="border-bottom:1px solid green">
                                       
										<div class="text-center">
                                            <h1 class="mb-0">Terms of Use</h1>
                                            
										</div>
                                    
									</div> <br><br>
                                    <div style="text-align:justify; margin:5px;">
                                    <p>Welcome to the Web-Based Educational Assistance Application System for the Municipality Office of San Antonio, Quezon (referred to as "we", "our", or "us").
                                         By using this platform, you agree to the following terms of use, which govern your use of the platform. 
                                        Please read these terms carefully before registering or using our services.</p>
                                        <h3>Acceptance of Terms</h3>
                                        <p>By accessing or using the Educational Assistance Application System, you agree to comply with and be bound by these Terms of Use and all applicable laws and regulations. 
                                            If you do not agree with these terms, you are not authorized to use our system.</p>
                                            <h3>Eligibility</h3>
              <p>You must be a student who is eligible to apply for educational assistance from the Municipality Office of San Antonio, Quezon.
                 You must provide accurate and up-to-date personal information during registration. 
                 The submission of false or misleading information may result in the rejection of your application or legal action.</p>
                 <h3>User Accounts</h3>
                 <p>When you create an account, you must provide accurate information. You are responsible for maintaining the confidentiality of your account login credentials and for all activities that occur under your account. 
                    You agree to notify us immediately if your account is compromised or accessed without your authorization.</p>
                 <h3>Use of the System</h3>
<p>You agree to use the system only for legitimate educational assistance applications. You must not:

<ul>
  <li>Use the system for any illegal activities or purposes.</li>  
<li>Distribute or share login credentials with unauthorized users.</li>
<li>Interfere with the proper operation of the system.</li>
<li>Upload any content that is harmful, offensive, or inappropriate</li>
</ul>


</p>
                 <h3>Application Submission</h3>
<p>All applications submitted via this system are subject to verification and approval by the Municipality Office of San Antonio, Quezon.
     You must provide complete and accurate information for your application to be considered. We reserve the right to reject or revoke any applications found to contain false or incomplete information.</p>
                 <h3>Document Upload</h3>
<p>You are responsible for uploading the necessary documents (e.g., school IDs, certificates, proof of indigency) required for the application process. All uploaded files must be free of viruses or malicious content. 
    We reserve the right to reject or delete any files that violate this policy.</p>
                 <h3>System Availability</h3>
<p>While we strive to ensure the platform is always available, we cannot guarantee uninterrupted access. 
    We reserve the right to modify, suspend, or discontinue the system at any time for maintenance, security updates, or other reasons without prior notice.</p>
                 <h3>Limitation of Liability</h3>
<p>To the extent permitted by law, we shall not be held liable for any damages or losses resulting from the use or inability to use the system, unauthorized access to your account, or any errors or omissions in your submitted application.</p>
                 <h3>Changes to the Terms</h3>
<p>We reserve the right to modify or update these Terms of Use at any time. We will notify users of any significant changes by posting updates on the platform or via email. 
    Continued use of the system after any changes constitutes acceptance of the new terms.</p>
                 <h3>Governing Law</h3>
<p>These Terms of Use are governed by and construed in accordance with the laws of the Philippines. 
    Any disputes arising out of or related to these terms will be resolved exclusively in the courts of the Philippines.</p>
                 <h3>Contact Information</h3>
                 <p>If you have any questions or concerns about these Terms of Use, please contact us at: 
                    <br> Municipality Office of San Antonio, Quezon <br>
                 Email: erikariyamagnaye@gmail.com 
                 <br>Phone Number: 09123456789</p>
                 <p style=" text-align:center">&copy Web Based Educational Assistance Application System 2024</p>
                
                                    </div>
                                          </div>
             
            </div>
        </div>

    </div>

  
          
	<?php include 'templates/footer.php' ?>
    <script>
            function openModal(){
                $('#pment').modal('show');
            }
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
    </script>
	<script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
