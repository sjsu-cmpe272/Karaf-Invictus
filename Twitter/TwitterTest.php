<?php

/*
This is Test file to test twitter API implemted below. This file implements 11 APIs.
To test each API change the Action number [1-11] for $action parameter.
$action = "Action1";

1. getTimeline
2. followHim
3. friendFollowerCount
4. sendDirectMessage
5. friendList
6. userLookup
7. reTweeters
8. followerIds
9. printTweets
10. printStatus
11. printDirectMessages

Author:
1. Abhijeet
2. Anvit
3. Gaurav
*/

ini_set('display_errors', 1);
require_once('TwitterBackFunc.php');
include 'AuthorizationKeys.php';

$action = "Action1";

// action1
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

//action2
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

// action3
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
 
// action4	 
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

// action5
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


// action6
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

// action7
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

// action8
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

// action9
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

// action10
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

// action11

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

switch($action) 
{
    case "Action1":
	echo "Now this is Action 1 <br />";
	getTimeline($settings, "dev_sjsu");
	break;
	case "Action2":
	echo "Following dev_sjsu <br />";
	followHim($settings, "dev_sjsu");
	break;
	case "Action3":
	echo "Now this is action 3<br />";
	friendFollowerCount($settings, "dev_sjsu");
	break;
	case "Action4":
	echo "Message Sent to dev_sjsu<br />";
	sendDirectMessage($settings, "dev_sjsu", "See my new message");
	break;
	case "Action5":
	echo "Now this is another action 5<br />";
	friendList($settings, '780997716012855296');
	break;
	case "Action6":
	echo "Now this is another action 6<br />";
	userLookup($settings, '780997716012855296');
	break;
	case "Action7":
	echo "Now this is another action 7 <br />";
	reTweeters($settings, '780997716012855296');
	break;
	case "Action8":
	echo "Now this is another action 8 <br />";
	followerIds($settings, '780997716012855296');
	break;
	case "Action9":
	echo "Now this is another action 9 <br />";
	printTweets($settings, "dev_sjsu");
	break;
	case "Action10":
	echo "Now this is another action 10 <br />";
	printStatus($settings, "dev_sjsu");
	break;
	case "Action11":
	echo "Now this is  action  11 <br />";
	printDirectMessages($settings);
	break;
	default:
    echo "Environment problem!";
}

?>
