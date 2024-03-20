
function get_all_rooms(){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		document.getElementById('room_data').innerHTML = this.responseText;
	}
	xhr.send('get_all_rooms');
}

let edit_room_form = document.getElementById('edit_room_form');

function edit_details(id){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		console.log(JSON.parse(this.responseText));
	}
	xhr.send('get_room='+responseText);
}
	
function toggleStatus(id,val){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (this.responseText==1) {
			alert('success','Status toggeled!');
			get_all_rooms();
		}else{
			alert('danger','Server Down!');
		}
	}
	xhr.send('toggleStatus='+id+'&value='+val);
}

function send_id(id){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		document.getElementById('form_data').innerHTML = this.responseText;
	}
	xhr.send('send_id='+id);
}

let add_image_form = document.getElementById('add_image_form');

function room_images(id,rname){
	document.querySelector('#add_img .modal-title').innerHTML = rname;
	add_image_form.elements['room_id'].value = id;
	add_image_form.elements['image'].value = '';

	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		document.getElementById('room_image_data').innerHTML = this.responseText;
	}
	xhr.send('get_room_images='+id);
}

function del_img(id){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (this.responseText==1) {
			alert('success','Image Deleted Successfully!');
			room_images(room_id,document.querySelector('#add_img .modal-title').innerHTML);
		}else{
			alert('danger','Sorry! Something Went Wrong');
		}
	}

	xhr.send('del_img='+id);
}

function thumb_img(img_id,room_id){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_rooms.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (this.responseText==1) {
			alert('success','Thumbnail Set Successfully!');
		}else{
			console.log(this.responseText);
			alert('danger','Sorry! Something Went Wrong');
		}
	}
	xhr.send('img_id='+img_id+'&room_id='+room_id);
}

function room_id(id){
	if (confirm('Are you sure, You want to delete this room?')) {
		let xhr = new XMLHttpRequest();
		xhr.open("POST","ajax/ajax_rooms.php",true);
		xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

		xhr.onload = function(){
			if (this.responseText==1) {
				alert('success','Room Deleted Successfully!');
				get_all_rooms();
			}else{
				alert('danger','Sorry! Something Went Wrong');
			}	
		}
		xhr.send('room_id='+id);
	}
}

window.onload = function(){
	get_all_rooms();
}