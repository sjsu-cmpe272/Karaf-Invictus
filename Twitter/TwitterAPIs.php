<?php
ini_set('display_errors', 1);
require_once('TwitterBackFunc.php');
include 'AuthorizationKeys.php';

//Action 1: Implemented by Anvit Saxena
function getTimeline($settings, $name)
{
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$count = 2;
$user = $name;
$getfield = '?screen_name='.$user.'&count='.$count;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
foreach($string as $items)
    {
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']["name"]."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
}

// Action 2: Implemented by Gaurav Gupta
function followHim($settings, $name)
{
$url = 'https://api.twitter.com/1.1/friendships/create.json';
$requestMethod = 'POST';
$postfields = array(
'screen_name' => $name,
'follow' => 'true',
);


$twitter = new TwitterAPIExchange($settings);
$twitter->buildOauth($url, $requestMethod)
->setPostfields($postfields)
->performRequest();
}

// Action 3: Implemented by Gaurav Gupta
function friendFollowerCount($settings, $name)
{
$url = 'https://api.twitter.com/1.1/users/lookup.json';
$getfield = '?screen_name='.$name;
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

foreach($string as $items)
	{
		echo "User @". $items['screen_name']. " has ". $items['followers_count']." Followers and ". $items['friends_count']. " Friends. This is not bad.<br />";
	}
}
 	 
// Action 4: Implemented by Gaurav Gupta
function sendDirectMessage($settings, $name, $message)
{
$url = 'https://api.twitter.com/1.1/direct_messages/new.json';
$requestMethod = 'POST';
$postfields = array(
    'screen_name' => $name,
    'text' => $message,
);

$twitter = new TwitterAPIExchange($settings);
 $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
}

// Action 5: Implemented by Anvit Saxena
function friendList($settings, $user_id)
{
$url = "https://api.twitter.com/1.1/friends/list.json";
$requestMethod = "GET";
$getfield = "?user_id=".$user_id;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);	
echo "<b><u>" . "Get Friend List of user ID " . $user_id . "</u></b>";
echo "<br>";
$i = 0;
foreach($string["users"] as $items)
{
$i++;
echo "Friend: " . $i . "<br>";
echo "Profile Picture : " . "<img src=" . $items['profile_image_url_https'] . "/>" . "<br />";
echo "Name : " . $items["name"] . "<br />";
echo "Screen name: ". $items["screen_name"]."<br />";
echo "<br><br>";
}
echo "<hr>";
}


 //Action 6: Implemented by Anvit Saxena
function userLookup($settings, $user_id)
{
$url = "https://api.twitter.com/1.1/users/lookup.json";
$requestMethod = "GET";
$getfield = "?user_id=" . $user_id;	
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
foreach($string as $items)
    {
        echo "Profile Picture: " . "<img src=" . $items['profile_image_url_https'] . "/>" . "<br />";
	    echo "Screen name: ". $items['screen_name']."<br />";
	    echo "Name: ". $items["name"]."<br />";
        echo "Followers: ". $items['followers_count']."<br />";
        echo "Friends: ". $items['friends_count']."<br />";
        echo "Listed: ". $items['listed_count']."<br />";
	    echo "<br><hr>";
    }
}

// Action7: Implemented by Abhijeet Rawat
function reTweeters($settings, $user_id)
{
$url = "https://api.twitter.com/1.1/statuses/retweeters/ids.json";
$requestMethod = "GET";
$count = 5;
$getfield = "?id=" . $user_id . "&count=" . $count;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);   
echo "<b><u>ReTweet IDS for the Tweet ID: " . $user_id . "</u></b>";
echo "<br><br>";
$i = 0;
foreach($string["ids"] as $items)
	{
		$i++;
		echo "ReTweet ID : " . $i. " = " . $items . "<br>";
	}
echo "<hr>";

}

//Action8: Implemented by Abhijeet Rawat
function followerIds($settings, $user_id)
{
$url = "https://api.twitter.com/1.1/followers/ids.json";
$requestMethod = "GET";
$getfield = "?user_id=" . $user_id;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
 ->buildOauth($url, $requestMethod)
 ->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
echo "<h1><u>Followers IDS for the Tweet ID " . $user_id . "</u></h1>";
echo "<br>";
$i = 0;
foreach($string["ids"] as $items)
{
$i++;
echo "ID: ". $items. "<br />";
echo "<br>";
}
}

// Action9: Implemented by Abhijeet Rawat
function printTweets($settings, $name)
{
$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
$getfield = "?q=".$name;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit(); }

echo "<h1><u>" . "Search tweets of " . $name . "</u></h1>";
echo "<br>";
$i = 0;
foreach($string["statuses"] as $items)
{
$i++;
echo "<u>Number : " . $i . "</u><br>";
echo "Profile Picture: " . "<img src=" . $items['user']['profile_image_url_https'] . "/>" . "<br />";
echo "Screen name: ". $items['user']['screen_name']."<br />";
echo "Name: ". $items['user']["name"]."<br />";
echo "Time and Date of Tweet: ".$items['created_at']."<br />";
echo "Tweet: ". $items['text']."<br />";
echo "<br>";
}
}

//Action 10: Implemented by Madhuvanthi Sekar
function printStatus($settings, $name)
{
$url = "https://api.twitter.com/1.1/statuses/show.json";
$requestMethod = "GET";
$getfield = "?id=" . $name;
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
echo "<h1><u>" . "Text and related details of the Tweet ID " . $string["id"] . "</u></h1> <br />";
echo "Text : " . $string["text"] . "<br />";
echo "Profile Picture" . "<img src=" . $string["user"]["profile_image_url_https"] . "/>" ."<br />";
echo "Name of Tweeter : " . $string["user"]["screen_name"] . "<br />";
echo "Screen name of Tweeter : " . $string["user"]["screen_name"] . "<br />";
echo "Location : " . $string["user"]["location"] . "<br />";
echo "Created At : " . $string["user"]["created_at"] . "<br />";
}

//Action 11: Implemented by Madhuvanthi Sekar
function printDirectMessages($settings)
{
$url = 'https://api.twitter.com/1.1/direct_messages/sent.json';
$getfield = '?count=20';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

foreach($string as $items)
    {
        echo "Recipient ".$items['recipient_screen_name']."<br />";
        echo "Message". $items['text']."<br /><hr />";
   }
}

// Data received from HTML file 
// Action will decide type of API call.
// nameX, messageX, userIDX are input parameters for APIs. 

$action = $_POST["taction"];
switch($action) 
{
    case "Action1":
	getTimeline($settings, $_POST["name1"]);
	break;
	case "Action2":
	echo "Following ". $_POST["name2"]." <br />";
	followHim($settings, $_POST["name2"]);
	break;
	case "Action3":
	friendFollowerCount($settings, $_POST["name3"]);
	break;
	case "Action4":
	echo "Message Sent to ".$_POST["name4"].  " <br />";
	sendDirectMessage($settings, $_POST["name4"], $_POST["message4"]);
	break;
	case "Action5":
	friendList($settings, $_POST["userId5"]);
	break;
	case "Action6":
	userLookup($settings, $_POST["userId6"]);
	break;
	case "Action7":
	reTweeters($settings, $_POST["userId7"]);
	break;
	case "Action8":
	followerIds($settings, $_POST["userId8"]);
	break;
	case "Action9":
	printTweets($settings, $_POST["name9"]);
	break;
	case "Action10":
	printStatus($settings, $_POST["name10"]);
	break;
	case "Action11":
	printDirectMessages($settings);
	break;
	default:
    echo "Environment problem!";
}

?>
