<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
  <style>
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box;}

    /* Button used to open the chat form - fixed at the bottom of the page */
    .open-button {
      background-color: #555;
      color           : white;
      padding         : 16px 20px;
      border          : none;
      cursor          : pointer;
      opacity         : 0.8;
      position        : fixed;
      bottom          : 23px;
      right           : 28px;
      width           : 280px;
    }

    /* The popup chat - hidden by default */
    .chat-popup {
      display : none;
      position: fixed;
      bottom  : 0;
      right   : 15px;
      border  : 3px solid #f1f1f1;
      z-index : 9;
    }

    /* Add styles to the form container */
    .form-container {
      max-width       : 300px;
      padding         : 10px;
      background-color: white;
    }

    /* Full-width textarea */
    .form-container textarea {
      width     : 100%;
      padding   : 15px;
      margin    : 5px 0 22px 0;
      border    : none;
      background: #f1f1f1;
      resize    : none;
      min-height: 200px;
    }

    /* When the textarea gets focus, do something */
    .form-container textarea:focus {
      background-color: #ddd;
      outline         : none;
    }

    /* Set a style for the submit/send button */
    .form-container .btn {
      background-color: #4CAF50;
      color           : white;
      padding         : 16px 20px;
      border          : none;
      cursor          : pointer;
      width           : 100%;
      margin-bottom   :10px;
      opacity         : 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
      background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover, .open-button:hover {
      opacity: 1;
    }
  </style>
</head>
<body>

  <h2>Popup Chat Window</h2>
  <p>Click on the button at the bottom of this page to open the chat form.</p>
  <p>Note that the button and the form is fixed - they will always be positioned to the bottom of the browser window.</p>

  <button class="open-button" onclick="openForm()">Chat</button>

  <div class="chat-popup" id="myForm">
    <form action="/action_page.php" class="form-container">
      <h1>Chat</h1>

      <label for="msg"><b>Message</b></label>
      <textarea placeholder="Type message.." name="msg" required></textarea>

      <button type="submit" class="btn">Send</button>
      <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    </form>
  </div>

  <script>
    function openForm() {
      document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
      document.getElementById("myForm").style.display = "none";
    }
  </script>

</body>
</html>