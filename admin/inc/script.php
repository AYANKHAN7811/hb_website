<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>
	function alert(type,msg) {
		let bs_class = (type == 'success')? 'alert-success': 'alert-danger';
		let element = document.createElement('div');
		element.innerHTML = `
			<div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
			  <strong class="me-3">${msg}</strong>
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		`;
        setTimeout(function(){
            document.querySelector('.custom-alert').remove();
        }, 3000); // 3000 milliseconds (3 seconds)
		document.body.append(element);
	}

	
	function setActive() {
	    let navbar = document.getElementById('dashboard-menu');
	    let a_tags = navbar.getElementsByTagName('a');

	    for (let i = 0; i < a_tags.length; i++) {
	        let file = a_tags[i].href.split('/').pop();
	        let file_name = file.split('.')[0];

	        if (document.location.href.indexOf(file_name) >= 0) {
	            a_tags[i].classList.add('active');
	        }
	    }
	}

	setActive();
</script>