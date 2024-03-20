let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form= document.getElementById('facility_s_form');


feature_s_form.addEventListener('submit',function(e){
	e.preventDefault();
	add_features();
});

function add_features(){
	let data = new FormData();

	data.append('name',feature_s_form.elements['feature_name'].value);
	data.append('add_features','');

	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_features_facilities.php",true);

	xhr.onload = function(){

		var myModal = document.getElementById('features-s');
		var modal = bootstrap.Modal.getInstance(myModal);
		modal.hide();
		if (this.responseText==1) {
			alert('success','New Feature Added!');
			feature_s_form.elements['feature_name'].value='';
			get_features();
		}else{
			alert('error','Server Down!');

		}


	}

	xhr.send(data);
}

function get_features(){

	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_features_facilities.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');


	xhr.onload = function(){
		document.getElementById('features_data').innerHTML = this.responseText;
	}

	xhr.send('get_features');
}
	
function get_facilities(){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_features_facilities.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
	xhr.onload = function(){
		document.getElementById('facilities_data').innerHTML = this.responseText;
	}
	xhr.send('get_facilities');
}
	

window.onload = function(){
	get_features();
	get_facilities();
}