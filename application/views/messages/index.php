<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="<?php echo $asset_url; ?>images/logo.png"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<style type="text/css">
  .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
#mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

#searchpeople {
  float: left;
  padding: 30px 15px 0 25px;
  width: 20%;
  display: none;
}

#fileform {
  float: left;
  padding: 30px 15px 0 25px;
  width: 20%;
  display: none;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.msg_upload_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
.sent_msg p a {
  color: yellow;
}
</style>
<!------ Include the above in your HEAD tag ---------->
</head>
<body>
<div class="container">
<h3 class=" text-center"></h3>
<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
<input type="hidden" id="selectedthreadid">
<input type="hidden" id="officer_id_session" value="<?php echo $this->session->officer_id; ?>">
<input type="hidden" id="client_receiver_id">
<input type="hidden" id="officer_role_session" value="<?php echo $this->session->officer_role; ?>">
<input type="hidden" id="threadnumrows" value="<?php echo $threadnumrows; ?>">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <img src="<?php echo $asset_url; ?>images/logomain.png" alt="PSC Logo" width="150px">
              <h4>CRM Messenger</h4>
              <?php
                if ($this->session->officer_role != "") {
              ?>
              <a href="dashboard">< Back to Dashboard</a>
              <?php
                }
              ?>

              <?php
                if ($this->session->officer_role == "") {
                  if((int) $threadnumrows == 0) {
              ?>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="notifclick">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
              </button>
              <?php
                  }
                }
              ?>

              <?php
                if ($this->session->officer_role == "") {
              ?>
              <a href="clientsignout" class="btn btn-primary"><i class="fa fa-power-off" aria-hidden="true"></i></a>
              <?php
                }
              ?>
              <br>
              
              
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
          <!--
            <div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
          -->
            <?php
              $thread_index = 0;
              foreach($thread as $row) {
            ?>
              <div class="chat_list">
                <div class="chat_people" onclick="OpenConvo(<?php echo $thread_index; ?>);">
                  <input type="hidden" id="threadid_<?php echo $thread_index; ?>" value="<?php echo $row->thread_id; ?>">
                  <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                  <div class="chat_ib">
                    <h5><?php
                      if($row->chattype == "managermanager") {
                        if($row->senderid == $this->session->officer_id) {
                          echo $row->receivername;
                          $othername = $row->receivername;
                          echo "<input type='hidden' value='' id='inqreceiverid_".$thread_index."'>";
                        } elseif($row->receiverid == $this->session->officer_id) {
                          echo $row->sendername;
                          $othername = $row->sendername;
                          echo "<input type='hidden' value='' id='inqreceiverid_".$thread_index."'>";
                        }
                      } else {
                        if($row->senderid == $this->session->officer_id) {
                          echo $row->inqreceivername;
                          $othername = $row->inqreceivername;
                          echo "<input type='hidden' value='".$row->inqreceiverid."' id='inqreceiverid_".$thread_index."'>";
                        } elseif($row->inqreceiverid == $this->session->officer_id) {
                          echo $row->sendername;
                          $othername = $row->sendername;
                          echo "<input type='hidden' value='".$row->inqreceiverid."' id='inqreceiverid_".$thread_index."'>";
                        }
                      }
                    ?> 
                    <span class="chat_date"><?php if ($row->recentmessagedatetime == "") { echo $row->created_date; } else { echo $row->recentmessagedatetime; } ?></span></h5>
                    <p>
                    <?php
                      if ($row->recentmessage != "") {
                        if ($row->recentmessagefrom == $this->session->officer_id) {
                          echo "You: ".$row->recentmessage; 
                        } else {
                          echo $othername.": ".$row->recentmessage; 
                        } 
                      } else {
                        echo "No conversation yet.";
                      }
                    ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php
              $thread_index++;
              }
            ?>
          </div>
        </div>
        <div class="mesgs" id="mesgs">
          <div class="msg_history" id="msg_history">
          <!--
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test which is a new approach to have all solutions</p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
          -->
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" id="write_msg" placeholder="Type a message" />
              <input type="file" id="attachfile" style="display: none;" />
              <button type="button" id="upload" onclick="checkThreadForUpload();"><i class="fa fa-upload" aria-hidden="true"></i></button>
              <?php
                if ($this->session->officer_role != "") {
              ?>
              <button type="button" id="add" onclick="opencloseSearchPanel();"><i class="fa fa-plus" aria-hidden="true"></i></button>
              <?php
                }
              ?>
              <button class="msg_send_btn" type="button" onclick="checkThreadForSending();"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
        <div class="searchpeople" id="searchpeople">
          <h3>New Contact</h3>
          <input type="hidden" id="searchpeopleindicator" value="hiddendiv">
          <button type="button" id="createthread" class="btn btn-primary btn-xs">Create thread</button><br>
          <?php
            $contactindex = 0;
            foreach($officer as $row2) {
              echo "<div class='newcontacts'><input type='radio' value='".$contactindex."' class='contactselect' id='contactselect-".$contactindex."' name='contactselect'> <input type='hidden' value='".$row2->contactid."' id='contactid-".$contactindex."'><input type='hidden' value='".$row2->contacttype."' id='contacttype-".$contactindex."'><img src='https://ptetutorials.com/images/user-profile.png' alt='sunil' style='width: 20px;'> ".$row2->contactname."</div>";
              $contactindex++;
            }
          ?>
        </div>
        <div class="fileform" id="fileform">
          <input type="hidden" id="fileindicator" value="hiddendiv">
          File Name: <input type="text" name="filename" id="filename" readonly><br>
          File URL: <input type="text" name="fileinput" id="fileinput" readonly><br>
          Client ID: <input type="text" name="clientid" id="clientid" readonly><br>
          Document Type: <select id="documentype" class="form-control">
            <option>Select Document Type</option>
            <option value="Student requirement">Student requirement</option>
            <option value="Visa application requirement">Visa application requirement</option>
            <option value="Sponsor requirement">Sponsor requirement</option>
          </select><br>
          Document Alias<select id="documentalias" class="form-control">
            <option>Select Alias</option>
            <option value="Passport">Passport</option>
            <option value="Birth certificate">Birth certificate</option>
            <option value="1x1 photo">1x1 photo</option>
          </select><br>
          <button id="savetoclientdocuments" style="background: #05728f; border: none; color: white;">Save to Client Documents</button>
        </div>
      </div>
    </div>

  </div> 

  <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kindly wait for an officer to be assigned to your case before you can initiate submission of documents.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  function opencloseSearchPanel() {
    if (document.getElementById("searchpeopleindicator").value == "hiddendiv") {
      document.getElementById("searchpeople").style.display = "block";
      document.getElementById("mesgs").style.width = "40%";
      document.getElementById("searchpeopleindicator").value = "showndiv";
    } else if (document.getElementById("searchpeopleindicator").value == "showndiv") {
      document.getElementById("searchpeople").style.display = "none";
      document.getElementById("mesgs").style.width = "60%";
      document.getElementById("searchpeopleindicator").value = "hiddendiv";
    }
  }

  function opencloseFilePanel() {
    if (document.getElementById("fileindicator").value == "hiddendiv") {
      document.getElementById("fileform").style.display = "block";
      document.getElementById("mesgs").style.width = "40%";
      document.getElementById("fileindicator").value = "showndiv";
    } else if (document.getElementById("fileindicator").value == "showndiv") {
      document.getElementById("fileform").style.display = "none";
      document.getElementById("mesgs").style.width = "60%";
      document.getElementById("fileindicator").value = "hiddendiv";
    }
  }


  function OpenConvo(index) {
    var id = document.getElementById("threadid_"+index).value;
    var baseurl = document.getElementById("baseurl").value;
    var officer_id_session = document.getElementById("officer_id_session").value;
    var inqreceiverid = document.getElementById("inqreceiverid_"+index).value;
    document.getElementById("client_receiver_id").value = inqreceiverid;
    var dynamichtml = "";
    $("#msg_history").empty();
    $.ajax({
      type: "GET",
      url: baseurl + "index.php/getconversation/" + id,
      success: function(data) {
          var obj = JSON.parse(data);

          for(var i = 0; i < obj.length; i++) {
            if (obj[i].message_from == officer_id_session) {
              dynamichtml = "<div class='outgoing_msg'>" +
                              "<div class='sent_msg'>" +
                              "<p>" + obj[i].message + "</p>" +
                              "<span class='time_date'> " + obj[i].message_time + "    |    " + obj[i].message_date + "</span> </div>" +
                            "</div>";
              $("#msg_history").append(dynamichtml);
            } else {
              dynamichtml = "<div class='incoming_msg'>" +
                              "<div class='incoming_msg_img'> <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'></div>" +
                              "<div class='received_msg'>" +
                                "<div class='received_withd_msg'>" +
                                  "<p>" + obj[i].message + "</p>" +
                                  "<span class='time_date'> " + obj[i].message_time + "    |    " + obj[i].message_date + "</span></div>" +
                              "</div>" +
                            "</div>";
              $("#msg_history").append(dynamichtml);
            }
          }

          document.getElementById("selectedthreadid").value = id;
          setTheClassClickEvent();
      },
      error: function(error) {
        alert("Error!");
      }
    });
  }

  function setTheClassClickEvent() {
    const nodeList = document.querySelectorAll(".filetosavetodocuments");
    for (let i = 0; i < nodeList.length; i++) {
      nodeList[i].onclick = function() {
        //alert(nodeList[i].getAttribute("href"));
        opencloseFilePanel();
        var client_receiver_id = document.getElementById("client_receiver_id").value;
        document.getElementById("clientid").value = client_receiver_id;
        document.getElementById("fileinput").value = nodeList[i].getAttribute("href");
        document.getElementById("filename").value = nodeList[i].innerHTML;
      }
    }
  }

  function OpenConvo2() {
    var baseurl = document.getElementById("baseurl").value;
    var officer_id_session = document.getElementById("officer_id_session").value;
    var dynamichtml = "";
    var selectedthreadid3 = document.getElementById("selectedthreadid").value;
    $("#msg_history").empty();
    $.ajax({
      type: "GET",
      url: baseurl + "index.php/getconversation/" + selectedthreadid3,
      success: function(data) {
          var obj = JSON.parse(data);

          for(var i = 0; i < obj.length; i++) {
            if (obj[i].message_from == officer_id_session) {
              dynamichtml = "<div class='outgoing_msg'>" +
                              "<div class='sent_msg'>" +
                              "<p>" + obj[i].message + "</p>" +
                              "<span class='time_date'> " + obj[i].message_time + "    |    " + obj[i].message_date + "</span> </div>" +
                            "</div>";
              $("#msg_history").append(dynamichtml);
            } else {
              dynamichtml = "<div class='incoming_msg'>" +
                              "<div class='incoming_msg_img'> <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'></div>" +
                              "<div class='received_msg'>" +
                                "<div class='received_withd_msg'>" +
                                  "<p>" + obj[i].message + "</p>" +
                                  "<span class='time_date'> " + obj[i].message_time + "    |    " + obj[i].message_date + "</span></div>" +
                              "</div>" +
                            "</div>";
              $("#msg_history").append(dynamichtml);
            }
          }
      },
      error: function(error) {
        alert("Error!");
        console.log(error);
      }
    });
  }

  function sendMessage() {
      var baseurl2 = document.getElementById("baseurl").value;
      var selectedthreadid2 = document.getElementById("selectedthreadid").value;
      var officer_id_session2 = document.getElementById("officer_id_session").value;
      var write_msg2 = document.getElementById("write_msg").value;

      $.ajax({
          type: "POST",
          url: baseurl2 + "index.php/savetextchat",
          data: {
            thread_id: selectedthreadid2, 
            message: write_msg2, 
            message_from: officer_id_session2, 
            message_type: "text",
            message_status: "Sent"
          },
          success: function(data) {
              var obj = JSON.parse(data);
              document.getElementById("write_msg").value = "";
              OpenConvo2();
              updateThread();
          },
          error: function(error) {
            alert("Error: "+error);
          }
      });
  }

  document.getElementById("createthread").onclick = function() {
    var baseurl2 = document.getElementById("baseurl").value;
    var contactselect = document.getElementsByClassName("contactselect");
    for (var j = 0; j < contactselect.length; j++) {
      if(document.getElementById("contactselect-"+j).checked == true) {
        var creator = document.getElementById("officer_id_session").value;
        var newcontactid = document.getElementById("contactid-"+j).value;
        var newcontacttype = document.getElementById("contacttype-"+j).value;
        
        $.ajax({
            type: "POST",
            url: baseurl2 + "index.php/createthread",
            data: {
              sender_id: creator, 
              receiver_id: newcontactid, 
              chattype: newcontacttype
            },
            success: function(data) {
                var obj = JSON.parse(data);
                alert("Successfully created new thread!");
                location.reload();
            },
            error: function(error) {
              alert("Error: "+error);
              console.log(error);
            }
        });
      }
    }
  }

  function checkThreadForUpload() {
    if(document.getElementById("selectedthreadid").value == "") {
      alert("Select by clicking a thread first before selecting a file!");
    } else {
      document.getElementById('attachfile').click();
    }
  }

  function checkThreadForSending() {
    if(document.getElementById("selectedthreadid").value == "") {
      alert("Select by clicking a thread first before sending a message!");
    } else {
      sendMessage();
    }
  }

  document.getElementById("savetoclientdocuments").onclick = function() {
        var clientid = document.getElementById("clientid").value;
        var fileinput = document.getElementById("fileinput").value;
        var filename = document.getElementById("filename").value;
        var documentype = document.getElementById("documentype").value;
        var baseurl3 = document.getElementById("baseurl").value;
        var documentalias = document.getElementById("documentalias").value;
        $.ajax({
            type: "POST",
            url: baseurl3 + "index.php/savetoclientdocuments",
            data: {
              client_id: clientid, 
              document_type: documentype, 
              document_link: fileinput,
              document_name: filename,
              alias: documentalias
            },
            success: function(data) {
                var obj = JSON.parse(data);
                alert("Successfully save the file to client's documents!");
                location.reload();
            },
            error: function(error) {
              alert("Error: "+error);
              console.log(error);
            }
        });

  }

</script>

<script src="<?php echo $asset_url; ?>google/firebase-app.js"></script>
<script src="<?php echo $asset_url; ?>google/firebase-analytics.js"></script>
<script src="<?php echo $asset_url; ?>google/firebase-firestore.js"></script>
<script src="<?php echo $asset_url; ?>google/firebase-storage.js"></script>
<script src="<?php echo $asset_url; ?>google/firebase-auth.js"></script>

<script src="<?php echo $asset_url; ?>google/firebase-save2.js" type="module"></script>

<script src="<?php echo $asset_url; ?>plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<script type="text/javascript">
  if(document.getElementById("officer_role_session").value == "") {
    if(document.getElementById("threadnumrows").value == "0") {
      document.getElementById("notifclick").click();
    }
  }
</script>