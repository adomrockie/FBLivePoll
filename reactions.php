<?php
///////////////////////////////////////////
//            CONFIGURATION              //
//  Set the ID of the Live Video below,  //
//  along with your app's access token   //
///////////////////////////////////////////

$videoid="VIDEO_ID_HERE";                                    // The ID of the Live Video
$access_token="ACCESS_TOKEN_HERE";   // Your Facebook app's access token in the format 1111111111111111|X1xX11xX_XXXxXxXXX1xXXx1XXX


set_time_limit(128); // Increase the standard time limit

// Below is the CURL magic!
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v2.8/?id='.$videoid.'&fields=reactions.type(LOVE).limit(0).summary(total_count).as(reactions_love),reactions.type(LIKE).limit(0).summary(total_count).as(reactions_like),reactions.type(ANGRY).limit(0).summary(total_count).as(reactions_angry),reactions.type(WOW).limit(0).summary(total_count).as(reactions_wow),reactions.type(HAHA).limit(0).summary(total_count).as(reactions_haha)&access_token='.$access_token.'');
$result = curl_exec($ch);
curl_close($ch);

$obj = json_decode($result);

// If you haven't started your Live Stream yet (ie. you don't have a Video ID), comment out the below lines with // to display "0" for each result.
$love=$obj->reactions_love->summary->total_count;
$wow=$obj->reactions_wow->summary->total_count;
$haha=$obj->reactions_haha->summary->total_count;
$like=$obj->reactions_like->summary->total_count;
$angry=$obj->reactions_angry->summary->total_count;


// If requesting an INDIVIDUAL reaction (ie. reaction variable is set in URL), display only the quantity of that specific reaction
if (isset($_GET['reaction'])){
$reaction=$_GET['reaction'];
if ($reaction=="love"){
echo $love;

} elseif ($reaction=="wow"){
echo $wow;

} elseif ($reaction=="haha"){
	echo $haha;

} elseif ($reaction=="like"){
	echo $like;

} elseif ($reaction=="angry"){
	echo $angry;

}

// Otherwise, if the reaction variable is NOT set in the URL, display the quantity of all reactions - this is good for testing purposes
} else {
echo "LOVE: ";
echo $love;

echo " WOW: ";
echo $wow;

echo " HAHA: ";
echo $haha;

echo " LIKE: ";
echo $like;

echo " ANGRY: ";
echo $angry;
}
?>