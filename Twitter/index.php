<!DOCTYPE HTML>
<!-- UI designed by Abhijeet Rawat -->
<!-- HTML Code by Anvit Saxena -->
<!-- Form data transfer implemented by Gaurav Gupta -->
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body style="background-color:powderblue;">

<h2>ReTwitter</h2>

<form method="post" action="retwitterapi.php">
<br><br>

<p>Actions:</p>

<hr/>
<input type="radio" name="taction" value="Action1">Get Timeline<br>
Enter Username: <input type="text" name="name1">
<br><hr>

<input type="radio" name="taction" value="Action2">Follow this person<br>
Enter Username: <input type="text" name="name2">
<br><hr>

<input type="radio" name="taction" value="Action3">Total Friends and Followers<br>
Enter Username: <input type="text" name="name3">
<br><hr>

<input type="radio" name="taction" value="Action4">Send Direct Message<br>
Enter Username: <input type="text" name="name4"><br>
Enter Message: <input type="text" name="message4">
<br><hr>

<input type="radio" name="taction" value="Action5">Friends list<br>
Enter User Id: <input type="text" name="userId5">
<br><hr>

<input type="radio" name="taction" value="Action6">Look up this person<br>
Enter User Id: <input type="text" name="userId6">
<br><hr>

<input type="radio" name="taction" value="Action7">Retweets of this person<br>
Enter User Id: <input type="text" name="userId7">
<br><hr>

<input type="radio" name="taction" value="Action8">Follower Info<br>
Enter User Id: <input type="text" name="userId8">
<br><hr>

<input type="radio" name="taction" value="Action9">Print Tweets of this person<br>
Enter Username: <input type="text" name="name9">
<br><hr>

<input type="radio" name="taction" value="Action10">Print Status of this person<br>
Enter Username: <input type="text" name="name10">
<br><hr>

<input type="radio" name="taction" value="Action11">Print my direct messages<br>
<br><hr>

<input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
