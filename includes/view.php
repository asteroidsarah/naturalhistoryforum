<?php 

class View{

	//possibly don't need this?
	// public function renderPost($oPost){

	// 		$sHTML = '<div class="postBox">';
	// 		$sHTML .= '<div class="postAuthor">';
	// 		$sHTML .= '<div class="avatar"><img src="assets/images/kokako.jpg" height="100" width="100" alt="avatar" /></div>';
	// 		$sHTML .= '<h3><a href="">Username</a></h3>';
	// 		$sHTML .= '<h4>User level</h4>';
	// 		$sHTML .= '</div>';
	// 		$sHTML .= '<div class="postControls">';
	// 		$sHTML .= '<p>15/07/2014 12:21</p>';
	// 		$sHTML .= '<a href="" class="button">Edit post</a>';
	// 		$sHTML .= '<a href="" class="button">Delete post</a>';
	// 		$sHTML .= '</div>';
	// 		$sHTML .= '<div class="postText">';
	// 		$sHTML .= '<p>Stewart Island offers some of the best land and sea birding in New Zealand. Bird watchers come from all over the world to enjoy our birds. Largely unmodified, the Island provides excellent habitat and food for native birds. Unlike other areas of New Zealand, it has not suffered the introduction of mustelids. The sea surrounding the Island is rich in food and attractive to a large number of seabirds.
	// 				 Ulva Island is a jewel in the crown offering a predator-free environment for rare and endangered birds including South Island saddleback, mohua, rifleman, Stewart Island robin.
	// 				Birds, which are often seen on Stewart Island and Ulva Island, include bellbird, tui, kaka, tomtit, grey warbler, kakariki and the New Zealand wood pigeon. Some of our birds are unique to the region and include the weka, robin and fernbird.</p>';
	// 		$sHTML .= '</div>';
	// 		$sHTML .= '</div>';

	// 		return $sHTML;


	// }

	public function renderUserDetails($oUser){
			$sHTML ='<div class="profileBox">';
			$sHTML .= '<div class="profileAvatarBox">';
			$sHTML .= '<img src="assets/images/'.htmlentities($oUser->avatarPhotopath).'" height="100" width="100" alt="avatar" />';
			$sHTML .= '</div>';
			$sHTML .= '<div class="profileText">';
			$sHTML .= '<ul>';
			$sHTML .= '<li><span>Username: </span>'.htmlentities($oUser->username).'</li>';
			$sHTML .= '<li><span>Occupation: </span>'.htmlentities($oUser->occupation).'</li>';
			$sHTML .= '<li><span>Interests: </span>'.htmlentities($oUser->interests).'</li>';
			$sHTML .= '<li><span>Contact: </span>'.htmlentities($oUser->email).'</li>';
			$sHTML .= '</ul>';
			$sHTML .= '<a href="edituserdetails.php" class="button">Edit</a>';
			$sHTML .= '</div>';
			$sHTML .= '</div>';

			return $sHTML;
	}


	//this function renders out all the posts in a thread ie. posts.html
	public function renderThread($oThread){
			$aPosts = $oThread->threadPosts;

			$oTopic = new Topic();
			$oTopic->load($oThread->topicID);

			$sHTML = '<div class="postsBar">';

			$sHTML	.= '<h2><a href="index.php">Board index</a></h2>';
			$sHTML .= '<p>></p>';
			$sHTML .= '<h2><a href="controller_topicthreads.php?topicID='.$oThread->topicID.'">'.htmlentities($oTopic->topicTitle).'<a></h2>';
			$sHTML .= '<p>></p>';
			$sHTML .= '<h2>'.htmlentities($oThread->threadTitle).'</h2>';
			$sHTML .= '</div>';
		
			for($iCount=0;$iCount<count($aPosts);$iCount++){
				$oPost = $aPosts[$iCount]; //a variable to capture the object at the current loop point of the array
				
				if($oPost->postActive == 1){

					$oPost->userID;
					$oUser = new User();
					$oUser->load($oPost->userID);

					$sUserlevelEcho = "";

					if($oUser->userLevel == 2){
						$sUserlevelEcho = "Admin";
					} else if($oUser->userLevel == 1){
						$sUserlevelEcho = "Registered user";
					} else {
						$sUserlevelEcho == "Guest";
					}


					$sHTML .= '<div class="postBox">';
					$sHTML .= '<div class="postAuthor">';
					$sHTML .= '<div class="avatar"><img src="assets/images/'.htmlentities($oUser->avatarPhotopath).'" height="100" width="100" alt="avatar" /></div>';
					$sHTML .= '<h3><a href="">'.htmlentities($oUser->username).'</a></h3>';
					$sHTML .= '<h4>'.htmlentities($sUserlevelEcho).'</h4>';
					$sHTML .= '</div>';
					$sHTML .= '<div class="postControls">';
					$sHTML .= '<p>'.htmlentities($oPost->postDate).'</p>';
					if (isset($_SESSION["userID"])) {
						 if($oUser->userID == $_SESSION["userID"] ){
						$sHTML .= '<a href="editpost.php?postID='.$oPost->postID.'" class="button">Edit post</a>';
						$sHTML .= '<a href="deletepost.php?postID='.$oPost->postID.'" class="button">Delete post</a>';
					}
					}
					$sHTML .= '</div>';
					$sHTML .= '<div class="postText">';
					$sHTML .= '<p>'.htmlentities($oPost->postMessage).'</p>';
					$sHTML .= '</div>';
					$sHTML .= '</div>';


				}
				
			}

			$sHTML .= '<div class="postReply">';
			$sHTML .= '<a href="newpost.php?threadID='.$oThread->threadID.'" class="button">+ POST REPLY</a>';
			$sHTML .= '</div>';
		
		return $sHTML;

	}


	//this function renders out all the threads in a topic ie. threads.html
	public function renderTopic($oTopic){
			$aThreads = $oTopic->topicThreads;
			$sHTML = '<a href="newthread.php?topicID='.$oTopic->topicID.'" class="button">+ NEW THREAD</a>';
			
			$sHTML .= '<div class="threadsBar">';
			$sHTML .= '<h2><a href="index.php">Board index</a></h2>';
			$sHTML .= '<p>></p>';
			$sHTML .= '<h2><a href="controller_topicthreads.php?topicID='.$oTopic->topicID.'">'.htmlentities($oTopic->topicTitle).'<a></h2>';
			$sHTML .= '<h3>Replies:</h3>';
			$sHTML .= '<h3>Created by:</h3>';
			$sHTML .= '<h3>Last post by:</h3>';
			$sHTML .= '</div>';

			for($iCount=0; $iCount<count($aThreads); $iCount++){
				$oThread = $aThreads[$iCount]; //a variable to capture the object at the current loop point of the array

				$oUser = new User();
				$oUser->load($oThread->userID);
				$aPosts = $oThread->threadPosts;

				$sLastPostAuthor = "";
				$sLastPostDate = "";
				if(count($aPosts) > 0){
					$oLastPost = $aPosts[count($aPosts) - 1];

					$oLastPostAuthor= new User();
					$oLastPostAuthor->load($oLastPost->userID);

					$sLastPostAuthor = $oLastPostAuthor->username;
					$sLastPostDate = $oLastPost->postDate;

				}
				

				$sHTML .= '<div class="threadBox">';
				$sHTML .= '<div class="threadStatusIcon">';
				$sHTML .= '<img src="assets/images/nonewposticon.png" alt="post icon"/>';
				$sHTML .= '</div>';
				$sHTML .= '<div class="threadTitle">';
				$sHTML .= '<h3><a href="controller_threadposts.php?threadID='.$oThread->threadID.'">'.htmlentities($oThread->threadTitle).'</a></h3>';
				$sHTML .= '</div>';
				$sHTML .= '<div class="threadReplies">';
				$sHTML .= '<p>'.count($aPosts).'</p>';
				$sHTML .= '</div>';
				$sHTML .= '<div class="threadCreatedBy">';
				$sHTML .= '<p><a href="">'.htmlentities($oUser->username).'</a></p>';
				$sHTML .= '<p class="small">'.htmlentities($oThread->threadDate).'</p>';
				$sHTML .= '</div>';
				$sHTML .= '<div class="threadLastPost">';
				$sHTML .= '<p><a href="">'.htmlentities($sLastPostAuthor).'</a></p>';
				$sHTML .= '<p class="small">'.htmlentities($sLastPostDate).'</p>';
				$sHTML .= '</div>';
				$sHTML .= '</div>';

			}

		return $sHTML;
	}

	//this is to render out into HTML all the topics in the database (stored in an array created by a Collections method getAllTopics)
	public function renderIndex($aTopicsList){
			$sHTML = '<div class="topicsBar">';
			$sHTML .= '<h2>TOPICS</h2>';
			$sHTML .= '<h3>Threads</h3>';
			$sHTML .= '<h3>Posts</h3>';
			$sHTML .= '</div>';

			for($iCount=0; $iCount<count($aTopicsList); $iCount++){
				$oTopic = $aTopicsList[$iCount];
				$aThreads = $oTopic->topicThreads;

				$iTopicPosts = "";

				for($iCount2=0; $iCount2<count($aThreads); $iCount2++){
					$oThread = $aThreads[$iCount2];
					$iTopicPosts += count($oThread->threadPosts);

				}


				$sHTML .= '<div class="topicBox">';
				$sHTML .= '<img src="assets/images/'.htmlentities($oTopic->topicPhotopath).'" height="80" width="80" class="topicIcon" />';
				$sHTML .= '<div class="topicTitles">';
				$sHTML .= '<h3><a href="controller_topicthreads.php?topicID='.htmlentities($oTopic->topicID).'">'.htmlentities($oTopic->topicTitle).'</a></h3>';
				$sHTML .= '<h4>'.htmlentities($oTopic->topicSubtitle).'</h4>';
				$sHTML .= '</div>';
				$sHTML .= '<p class="topicDescription">'.htmlentities($oTopic->topicDescription).'</p>';
				$sHTML .= '<p class="threadCounter">'.count($aThreads).'</p>';
				$sHTML .= '<p class="postCounter">'.htmlentities($iTopicPosts).'</p>';
				$sHTML .= '</div>';
			}

			return $sHTML;
	}


}




 ?>