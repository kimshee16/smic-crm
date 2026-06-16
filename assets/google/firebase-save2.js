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

const fileSelector2 = document.getElementById('attachfile');
var fileList2 = 0;

fileSelector2.addEventListener('change', (event) => {
    fileList2 = event.target.files;

    var FileDesc = fileList2[0]["name"];
	var ImageURL = "";
	var uploadTask = firebase.storage().ref("chatfile/"+FileDesc).put(fileList2[0]);

	uploadTask.on('state_changed', function(snapshot){
		var progress2 = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
		console.log('Uploading ' + progress2 + '%');
	},
	function(error) {
		alert('Error in saving the image: ');
		console.log(error);
	},
	function() {
		uploadTask.snapshot.ref.getDownloadURL().then(function(url){
			var baseurl = document.getElementById("baseurl").value;
			var selectedthreadid = document.getElementById("selectedthreadid").value;
			var officer_id_session = document.getElementById("officer_id_session").value;

			$.ajax({
			    type: "POST",
			    url: baseurl + "index.php/savefilechat",
			    data: {
			    	thread_id: selectedthreadid, 
			    	message: "<a href='" + url + "' target='_blank' class='filetosavetodocuments'>" + FileDesc + "</a>", 
			    	message_from: officer_id_session, 
			    	message_type: "file",
			    	message_status: "Sent"
			    },
			    success: function(data) {
			        var obj = JSON.parse(data);
			        OpenConvo2(selectedthreadid);
			        updateThread();
			    },
			    error: function(error) {
			      alert("Error: "+error);
			    }
			});

		})
	});
});