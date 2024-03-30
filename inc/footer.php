<!-- Footer -->
<div class="container-fluid bg-white mt-5  ">
	<div class="row">
		<div class="col-lg-4 p-4">
			<h3 class="h-font fw-bold fs-3 mb-3"><?php echo $title_row['site_title']; ?></h3>
			<p><?php echo $title_row['site_about']; ?></p>
		</div>
		<div class="col-lg-4 p-4">
			<h5 class="mb-3">Links</h5>
			<a href="index.php" class="d-inline-block mb-2 text-decoration-none text-dark">Home</a><br>
			<a href="rooms.php" class="d-inline-block mb-2 text-decoration-none text-dark">Rooms</a><br>
			<a href="facilities.php" class="d-inline-block mb-2 text-decoration-none text-dark">Facilities</a><br>
			<a href="contact.php" class="d-inline-block mb-2 text-decoration-none text-dark">Contact Us</a><br>
			<a href="about.php" class="d-inline-block mb-2 text-decoration-none text-dark">About Us</a>
		</div>
		<div class="col-lg-4 p-4">
			<h5 mb-3>Follow Us</h5>
			<a href="<?php echo $row['tw']; ?>" class="d-inline-block mb-3 text-dark text-decoration-none">
				<i class="bi bi-twitter  me-1"></i> Twitter
			</a>
			<br>
			<a href="<?php echo $row['fb']; ?>" class="d-inline-block mb-3 text-dark text-decoration-none">
				<i class="bi bi-facebook me-1"></i> Facebook
			</a>
			<br>
			<a href="<?php echo $row['insta']; ?>" class="d-inline-block  text-dark text-decoration-none">
				<i class="bi bi-instagram me-1"></i> Instagram
			</a>
		</div>
	</div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by Ayan khan</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script >
let register_form = document.getElementById('register-form');
let login_form = document.getElementById('login-form');
let forgot_form = document.getElementById('forgot-form');

function showAlert(type, msg) {
    var bsClass = (type === "success") ? "alert-success" : "alert-danger";
    
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert ' + bsClass + ' alert-dismissible fade show custom-alert';
    alertDiv.setAttribute('role', 'alert');

    var strongTag = document.createElement('strong');
    strongTag.className = 'me-3';
    strongTag.textContent = msg;

    var closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'btn-close';
    closeButton.setAttribute('data-bs-dismiss', 'alert');
    closeButton.setAttribute('aria-label', 'Close');

    alertDiv.appendChild(strongTag);
    alertDiv.appendChild(closeButton);

    document.body.appendChild(alertDiv);

    setTimeout(function () {
        alertDiv.remove();
    }, 3000);
}


jQuery(document).ready(function () {
    jQuery('#register-form').submit(function (event) {
        event.preventDefault();
        
        var formData = new FormData(this);
        formData.append("image", jQuery('#pic')[0].files[0]);

        jQuery.ajax({
            type: 'POST',
            url: 'ajax/login_register.php',
            data: formData,
            contentType: false,
            processData: false, // Important when sending FormData
            success: function (response) {
            	console.log(response);
                if (response=='Password dose not match') {
                	showAlert('error','Password does not match !');
                }else if (response=='email already exists') {
                	showAlert('error','email already exists');
                }else if (response=='phone number already used') {
                	showAlert('error','phone number already used');
                }else if (response=='mail failed') {
                	showAlert('error','Cannot send confermation email , Server down !');
                }else if (response=='insert failed') {
                	showAlert('error','Registration failed');
                }else if (response=='large img') {
                	showAlert('error','Image size should be less than 2MB');
                }else if (response=='formate not supported') {
                	showAlert('error','Image format not supported.');
                }else if (response==1) {
                	showAlert('success','Registration successfull ,varification link send to your email');
                	register_form.reset();
	            }else{
                    showAlert('error','Someting Went wrong');
                }
            },
            error: function (error) {
                console.log('error' + error);
                // console.error('Error:', error);
            }
        });
    });
});

jQuery(document).ready(function () {
    jQuery('#login-form').submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        formData.append('login',"");    
        jQuery.ajax({
            type: 'POST',
            url: 'ajax/login_register.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response=='inv_email_mob') {
                    showAlert('error','Invalid Email OR Mobile Number. !');
                }else if (response=='not_verified') {
                    showAlert('error','User Not Varified. !');
                }else if (response=='Inactive') {
                    showAlert('error','Account Suspended, please contact admin. !');
                }else if (response=='invalid_pass') {
                    showAlert('error','Incorrect Password. !');
                }else {
                    let fileurl = window.location.href.split('/').pop().split('?').shift();

                    if (fileurl == 'room_details.php') {
                        window.location = window.location.href;
                    }else{
                        window.location = window.location.pathname;
                    }

                }
            },
            error: function (error) {
                console.log('Error: ' + error);
            }
        });
    });
});

// jQuery(document).ready(function () {
//     jQuery('#forgot-form').submit(function (event) {
//         event.preventDefault();

//         var formData = new FormData(this);
//         formData.append('forgot_pass',""); 

//         jQuery.ajax({
//             type: 'POST',
//             url: 'ajax/login_register.php',
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (response) {
//                 console.log(response);
//                 if (response=='inv_email') {
//                     showAlert('error','Invalid Email. !');
//                 }else if (response=='not_verified') {
//                     showAlert('error','Email Not Varified. !');
//                 }else if (response=='Inactive') {
//                     showAlert('error','Account Suspended, please contact admin. !');
//                 }else if (response=='mail failed') {
//                     showAlert('error','Cannot send email, Server down. !');
//                 }else if (response=='upd_failed') {
//                     showAlert('error','Account recovery failed, Server down. !');
//                 }else {
//                     showAlert('success','Reset link send to email. !');
//                     forgot_form.reset();
//                 }
//             },
//             error: function (error) {
//                 console.log('Error: ' + error);
//             }
//         });
//     });
// });

function setActive() {
    let navbar = document.getElementById('nav-bar');
    let a_tags = navbar.getElementsByTagName('a');

    for (let i = 0; i < a_tags.length; i++) {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];

        if (document.location.href.indexOf(file_name) >= 0) {
            a_tags[i].classList.add('active');
        }
    }
}

function checkLoginToBook(status,room_id){
    if(status){
        window.location.href='confirm_booking.php?id='+room_id;
    }else{
        showAlert('error','Please Login to book room. !');
    }
}

setActive();
</script>
