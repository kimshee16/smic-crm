const firebaseConfig = {
  apiKey: "AIzaSyDnLZvP1x2mn0U_txJbA02hT7sAR3s9FYQ",
  authDomain: "psc-crm.firebaseapp.com",
  projectId: "psc-crm",
  storageBucket: "psc-crm.appspot.com",
  messagingSenderId: "83524403626",
  appId: "1:83524403626:web:563c081e590c5814832bd3",
  measurementId: "G-91M3FJPV6M"
};

firebase.initializeApp(firebaseConfig);
let cloudDB = firebase.firestore();

const fileSelector = document.getElementById('documentfile');
var fileList = 0;
fileSelector.addEventListener('change', (event) => {
    fileList = event.target.files;
    alert("Document file added!");
});


document.getElementById("savefiletofirebase").onclick = function() {
	var ImageName = fileList[0]["name"];
	var ImageURL = "";
	var uploadTask = firebase.storage().ref("documents/"+ImageName).put(fileList[0]);

	uploadTask.on('state_changed', function(snapshot){
		var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
		console.log('Uploading ' + progress + '%');
	},
	function(error) {
		alert('Error in saving the image: ');
		console.log(error);
	},
	function() {
		uploadTask.snapshot.ref.getDownloadURL().then(function(url){
			var baseurl = document.getElementById("baseurl1").value;
			var client_id = document.getElementById("client_id1").value;
			var documentype = document.getElementById("documentype").value;
			var documenalias = document.getElementById("documenalias").value;

			var today = new Date();
			var datetoday = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

/*
		    cloudDB.collection("documents").add(
			{
				documentype: documentype,
				documenturl: url,
				filename: ImageName,
				clientid: client_id,
				dateuploaded: datetoday
			}
			)
			.then(function (docRef){
				alert("Successfully saved the document!");
				ResetFile();
				setDocumentsTable();
			})
			.catch(function(error){
				console.log(error);
			})
*/

			$.ajax({
			    type: "POST",
			    url: baseurl + "index.php/adddocuments",
			    data: {
			    	client_id: client_id, 
			    	document_type: documentype, 
			    	document_name: ImageName, 
			    	document_link: url,
			    	alias: documenalias
			    },
			    success: function(data) {
			        var obj = JSON.parse(data);
			        alert("Successfully uploaded the new document!");
			        //console.log(obj);
			        setDocumentsTable2();
			        $("#documentModal").modal("hide");
    				ResetFile();
			    },
			    error: function(error) {
			      alert("Error: "+error);
			    }
			});

		})
	}
	)
}

function setDocumentsTable() {
    (async () => {
      var tabledata = "";
      document.getElementById("documentrow1").innerHTML = "";
      document.getElementById("deletedocumentdiv").innerHTML = "";
	  var clientid = document.getElementById("client_id2").value;
	  var imageasseturl2 = document.getElementById("imageasseturl2").value;
	  
      const arr = await getDocuments(clientid);
      for(var i = 0; i < arr.length; i++) {
	  	var modi = i % 5;
	  	if (i > 0 && modi == 0) {
	  		tabledata += "<div class='col'><center><a href='" + arr[i].documenturl + "'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + arr[i].documentype + "</b><br><label style='font-size: 12px;'>" + arr[i].filename + "</label></a></center></div></div><div class='row'>";
	  	} 
	  	else if (i == 0) {
	  		tabledata += "<div class='row'><div class='col'><center><a href='" + arr[i].documenturl + "'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + arr[i].documentype + "</b><br><label style='font-size: 12px;'>" + arr[i].filename + "</label></a></center></div>"
	  	}
	  	else if (i == (arr.length-1)) {
	  		tabledata += "<div class='col'><center><a href='" + arr[i].documenturl + "'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + arr[i].documentype + "</b><br><label style='font-size: 12px;'>" + arr[i].filename + "</label></a></center></div></div>"
	  	}
	  	else {
	  		tabledata += "<div class='col'><center><a href='" + arr[i].documenturl + "'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + arr[i].documentype + "</b><br><label style='font-size: 12px;'>" + arr[i].filename + "</label></a></center></div>";
	  	}
	  	let documentdiv = document.createElement("div");
		documentdiv.innerHTML = "<input type='checkbox' class='deleteselect'> " + arr[i].filename + " &nbsp;&nbsp;&nbsp;<input type='hidden' id='deletehiddenid-"+i+"' value='"+arr[i].filename+"'>";
	  	document.getElementById("deletedocumentdiv").appendChild(documentdiv);
	  }
	  document.getElementById("documentrow1").innerHTML = tabledata;
	})()
}

function setDocumentsTable2() {
	var clientid = document.getElementById("client_id2").value;
	var baseurl = document.getElementById("baseurl1").value;
	$.ajax({
    type: "GET",
    url: baseurl + "index.php/getdocuments/"+clientid,
    success: function(data) {
        var obj = JSON.parse(data);
        //alert(obj[0].program);
        console.log(obj);
        var tabledata = "";
	      document.getElementById("documentrow1").innerHTML = "";
		  var clientid = document.getElementById("client_id2").value;
		  var imageasseturl2 = document.getElementById("imageasseturl2").value;
		  
	      for(var i = 0; i < obj.length; i++) {
		  	var modi = i % 5;
		  	if (i > 0 && modi == 0) {
		  		tabledata += "<div class='col'><center><input type='checkbox' class='deleteselect' value='"+obj[i].fbid+"'><a href='" + obj[i].document_link + "' target='_blank'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + obj[i].document_type + "</b><br><b style='font-size: 12px;'>" + obj[i].alias + "</b> - <label style='font-size: 12px;'>" + obj[i].document_name + "</label></a></center></div></div><div class='row'>";
		  	} 
		  	else if (i == 0) {
		  		tabledata += "<div class='row'><div class='col'><center><input type='checkbox' class='deleteselect' value='"+obj[i].fbid+"'><a href='" + obj[i].document_link + "' target='_blank'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + obj[i].document_type + "</b><br><b style='font-size: 12px;'>" + obj[i].alias + "</b> - <label style='font-size: 12px;'>" + obj[i].document_name + "</label></a></center></div>"
		  	}
		  	else if (i == (obj.length-1)) {
		  		tabledata += "<div class='col'><center><input type='checkbox' class='deleteselect' value='"+obj[i].fbid+"'><a href='" + obj[i].document_link + "' target='_blank'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + obj[i].document_type + "</b><br><b style='font-size: 12px;'>" + obj[i].alias + "</b> - <label style='font-size: 12px;'>" + obj[i].document_name + "</label></a></center></div></div>"
		  	}
		  	else {
		  		tabledata += "<div class='col'><center><input type='checkbox' class='deleteselect' value='"+obj[i].fbid+"'><a href='" + obj[i].document_link + "' target='_blank'><img src='" + imageasseturl2 + "' style='width: 70px; width: 65px;'><br><b>" + obj[i].document_type + "</b><br><b style='font-size: 12px;'>" + obj[i].alias + "</b> - <label style='font-size: 12px;'>" + obj[i].document_name + "</label></a></center></div>";
		  	}
		  }
		  document.getElementById("documentrow1").innerHTML = tabledata;
    },
    error: function(error) {
      alert("Error!");
    }
});
}

const getDocuments = (clientid) => {
  return cloudDB.collection('documents').where('clientid', '==', clientid).get().then(snapshot => snapshot.docs.map(x => x.data()));
  //return cloudDB.collection('users').get().then(snapshot => snapshot.docs.map(x => x.data()));
}

setDocumentsTable2();

document.getElementById("deletedocumentfile").onclick = function() {
	var deletefile = document.getElementsByClassName("deleteselect");
	var baseurl = document.getElementById("documentbaseurl").value;
	for(var i = 0; i < deletefile.length; i++) {
		if(deletefile[i].checked == true) {
			$.ajax({
			    type: "GET",
			    url: baseurl + "index.php/deletedocuments/" + deletefile[i].value,
			    success: function(data) {
			    },
			    error: function(error) {
			      alert(error);
			    }
			});
		}
	}
	alert("Successfully deleted the selected document/s!");
    setDocumentsTable2();
}


/*
chrome.storage.local.get(['sessionemail'], function(result) {
  if(typeof result.sessionemail !== 'undefined'){
  	  document.getElementById("emailsession").value = result.sessionemail;
  	  loginSet();
  	  historydataSet();
  }
});

document.getElementById("registerdata").onclick = function() {
	datafullname = document.getElementById("fullname").value;
	dataemail = document.getElementById("email1").value;
	datapassword = document.getElementById("password1").value;

	(async () => {
	  const arr = await getUser(dataemail);

	  if(arr.length != 0) {
	  	alert("Email already existing!");
	  } else {
	  		cloudDB.collection("users").add(
			{
				fullname: datafullname,
				email: dataemail,
				password: datapassword
			}
			)
			.then(function (docRef){
				alert("Successfully registered user with ID " + docRef.id);
				ResetRegister();
			})
			.catch(function(error){
				console.log(error);
			})
	  }

	})()
}

document.getElementById("logindata").onclick = function() {
	(async () => {
	  dataemail = document.getElementById("email2").value;
	  datapassword = document.getElementById("password2").value;

	  const arr = await getUser(dataemail);

	  if(arr.length == 0) {
	  	alert("Incorrect credentials!");
	  } else {
	  	if(arr[0].password == datapassword) {
	  		alert("Successfully logged in!");
	  		chrome.storage.local.set({sessionemail: arr[0].email});
	  		loginSet();
	  		historydataSet();
	  		document.getElementById("emailsession").value = arr[0].email;
	  	} else {
	  		alert("Incorrect credentials!");
	  	}
	  }
	})()
	ResetLogin();
}

document.getElementById("historydata").onclick = function() {
	chrome.history.search({text: '', maxResults: 100}, function(data) {
	    data.forEach(function(page) {
	    	historyarray2.push(page.id);
	    	historyarray2.push(page.title);
	    	historyarray2.push(page.url);
	    	historyarray2.push(page.lastVisitTime);
	    	historyarray.push(historyarray2);
			historyarray2 = [];
	    });

	    var today = new Date();
		var datetoday = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

		var obj = Object.assign({}, historyarray); // {0:"a", 1:"b", 2:"c"}
	    
	    cloudDB.collection("history").add(
				{
					user: document.getElementById("emailsession").value,
					historydata: obj,
					date: datetoday
				}
		)
		.then(function (docRef){
			console.log("Successfully saved the history data " + docRef.id);
			historyarray = [];
		})
		.catch(function(error){
			console.log(error);
		})  
	});
}

document.getElementById("registerbutton").onclick = function() {
	registerSet();
}

document.getElementById("backtologinbutton").onclick = function() {
	backtologinSet();
}

document.getElementById("signoutbutton").onclick = function() {
	var confirm1 = confirm("Are you sure you want to logout?");
	if(confirm1 == true) {
		logoutSet();
		ResetLogin();
	}
}

const getUser = (dataemail, datapassword) => {
  return cloudDB.collection('users').where('email', '==', dataemail).get().then(snapshot => snapshot.docs.map(x => x.data()));
  //return cloudDB.collection('users').get().then(snapshot => snapshot.docs.map(x => x.data()));
}

const CheckExistingUser = (dataemail) => {
  return cloudDB.collection('users').where('email', '==', dataemail).get().then(snapshot => snapshot.docs.map(x => x.data()));
  //return cloudDB.collection('users').get().then(snapshot => snapshot.docs.map(x => x.data()));
}

function ResetRegister() {
	document.getElementById("fullname").value = "";
	document.getElementById("email1").value = "";
	document.getElementById("password1").value = "";
}

function ResetLogin() {
	document.getElementById("email2").value = "";
	document.getElementById("password2").value = "";
}

function loginSet() {
	document.getElementById("historyresults").style.display = "block";
	document.getElementById("login").style.display = "none";
	document.getElementById("signoutbutton").style.display = "block";
}

function logoutSet() {
	document.getElementById("historyresults").style.display = "none";
	document.getElementById("login").style.display = "block";
	document.getElementById("signoutbutton").style.display = "none";

	chrome.storage.local.remove(["sessionemail"],function(){
	 var error = chrome.runtime.lastError;
	    if (error) {
	        console.error(error);
	    } else {
	    	alert("Successfully logged out");
	    }
	})
	
}

*/
