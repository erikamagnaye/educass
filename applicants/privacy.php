
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
                                            <h1 class="mb-0">Privacy Policy</h1>
                                            
										</div>
                                    
									</div> <br><br>
                                    <div style="text-align:justify; margin:5px;">
                                    <p>   This Privacy Policy outlines how we collect, use, and protect your personal information when you use the Educational Assistance Application System  operated by the Municipality Office of San Antonio, Quezon. By using the System, you consent to the collection and use of your personal data as described in this policy. We are committed to safeguarding your privacy and ensuring compliance with all applicable data protection laws, including the <strong>Philippine Data Privacy Act of 2012.</strong></p>
                                          <h3>Information We Collect</h3>
                                        <p>We collect the following types of personal information when you register for and use our system: </p>
                                        <ul>
                                            <li><strong>Personal Information:</strong> Name, address, contact number, email address, birthdate,Age,  school information, and other personal details.</li>
                                            <li><strong>Document Information:</strong> Uploaded documents such as school IDs, certificates of registration, grades, letter of intent, and proof of indigency.</li>
                                        
                                        </ul>
                                        <h3> How We Use Your Information</h3> 
                                        <p>We use the personal information collected for the following purposes:</p>
                                           <ul>
                                            <li>To process and review your educational assistance application.</li>
                                            <li>To verify your eligibility for assistance.</li>
                                            <li>To communicate with you regarding your application status.</li>
                                            <li>To maintain records as required by law.</li>
                                            <li>To improve our services and system functionality.</li>
                                           </ul>
                                           <h3>How We Protect Your Information</h3> 
                                           <p>We take the protection of your personal information seriously. We implement appropriate technical and organizational security measures to protect your data from unauthorized access, disclosure, alteration, or destruction. These measures include:</p>
                                           <ul>
                                            <li>Data encryption</li>
                                            <li>Secure storage of personal information.</li>
                                            <li>Regular security audits</li>
                                            <li>Only authorized personnel have access to your personal data, and they are required to maintain the confidentiality of your information.</li>
                                           </ul>
                                           <h3>Data Sharing and Disclosure</h3>
                                           <p>We will not sell, rent, or share your personal information with third parties except under the following circumstances:</p>
            <h5>Service Providers</h5>
            <p>We may share your personal data with trusted third-party service providers who assist in the operation of the System (e.g., cloud storage, hosting services). These service providers are contractually bound to protect your personal information and use it only for the specific purposes of providing the service.</p>
<h5>Legal Requirements</h5>
            <p>We may disclose your personal data if required to do so by law, in response to lawful requests by public authorities (e.g., a court order or government investigation), or to protect the legal rights of the Municipality Office of San Antonio, Quezon, or other users.</p>
                 <h5>Consent-Based Sharing</h5> 
            <p>In cases where you explicitly agree, we may share your data with other entities, such as educational institutions or government bodies, for purposes related to your educational assistance application.</p>
            
            <h3>Data Retention</h3>
            <p>We retain your personal data only as long as it is necessary for the purposes outlined in this Privacy Policy or as required by law. Once your data is no longer required, we will securely delete or anonymize it to prevent unauthorized access.</p>
          <ul>
            <li><strong>Retention for Legal Compliance:</strong> In some cases, we may be required to retain certain data for longer periods to comply with legal obligations.</li>
          <li><strong>Deletion Request:</strong> If you request that we delete your personal data, we will make reasonable efforts to comply, subject to any legal obligations that require us to retain the data.</li>
        </ul>
          <h3>Your Rights</h3>
          <p>You have the following rights regarding your personal data:</p>
          <li>You have the right to access the personal data we hold about you and request a copy.</li>
<li>You may request the deletion of your personal data, provided that it is no longer needed for the purpose for which it was collected or we are not legally obligated to retain it.</li>
   <li>You may object to certain uses of your personal data, such as processing for direct marketing or analytics.</li>      
<h3>Consent and Withdrawal</h3>
<p>By using the System, you consent to the collection and use of your personal data as outlined in this Privacy Policy. You may withdraw your consent at any time by contacting us at EMAIL. However, please note that withdrawing consent may limit your ability to use certain features of the System, such as submitting an educational assistance application.</p>
<h3>Changes to this Privacy Policy</h3>
<p>We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. If we make significant changes, we will notify you via the System or email. Your continued use of the System after any such changes constitutes your acceptance of the updated policy.</p>
<h3>Children’s Privacy</h3>
<p>The System is intended for use by students who are eligible to apply for educational assistance. We do not knowingly collect personal information from minors under the age of 18 without the consent of a parent or guardian. If we learn that we have collected personal information from a minor without such consent, we will promptly delete the information. If you believe that we may have collected personal information from a minor, please contact us at the email provided below.</p>
<h3>Data Breach</h3>
<p>In the event of a data breach that may compromise your personal data, we will notify you and the appropriate authorities in accordance with applicable laws. We will take all necessary steps to contain the breach and prevent further damage.</p>

<h3>Contact Information</h3>
                 <p>If you have any questions or concerns about these Terms of Use, please contact us at: 
                    <br> Municipality Office of San Antonio, Quezon <br>
                 Email: educationalassistancesaq@gmail.com 
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
