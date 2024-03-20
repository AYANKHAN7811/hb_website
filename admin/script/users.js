
function get_users(){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_users.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		document.getElementById('users_data').innerHTML = this.responseText;
	}
	xhr.send('get_users');
}

function toggleStatus(id,val){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_users.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (this.responseText==1) {
			alert('success','Status toggeled!');
			get_users();
		}else{
			alert('danger','Server Down!');
		}
	}
	xhr.send('toggleStatus='+id+'&value='+val);
}

function remove_user(id){
	if (confirm('Are you sure, You want to remove this user ?')) {
		let xhr = new XMLHttpRequest();
		xhr.open("POST","ajax/ajax_users.php",true);
		xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

		xhr.onload = function(){
			if (this.responseText==1) {
				alert('success','User removed !');
				get_users();
			}else{
				alert('danger','User removal failed' + this.responseText);
			}	
		}
		xhr.send('id='+id);
	}
}

function search_user(username){
	let xhr = new XMLHttpRequest();
	xhr.open("POST","ajax/ajax_users.php",true);
	xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');

	xhr.onload = function(){
		document.getElementById('users_data').innerHTML = this.responseText;
	}
	xhr.send('search_user&name='+username);
}

window.onload = function(){
	get_users();
}