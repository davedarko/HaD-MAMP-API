<?php

// hackadayAPI.php

/* still missing:
	- get all images https://api.hackaday.io/v1/projects/20769/images?api_key=YOUR_API_KEY
- get details GET https://api.hackaday.io/v1/projects/20769/details?api_key=YOUR_API_KEY
	- get all files? not even sure they're reachable through app

 *
 * */

$api_key = "YOUR_API_KEY";
$user_id = YOUR_USER_ID;

function add_project($project) {
	
	global $conn;
	$sql = "INSERT INTO projects (id, name, summary, description, image_url, created, updated, tags) VALUES ";

	$sql.= "(";
		$sql.= $project->id . ', ';
		$sql.= '"'.$conn->escape_string($project->name) . '", ';
		$sql.= '"'.$conn->escape_string($project->summary) . '", ';
		$sql.= '"'.$conn->escape_string($project->description) . '", ';
		$sql.= '"'.$conn->escape_string($project->image_url) . '", ';
		$sql.= $project->created . ', ';
		$sql.= $project->updated . ', ';
		$sql.= '"'.$conn->escape_string(implode(',', $project->tags)). '" ';
	$sql.= ")";
	
	$conn->query($sql);

	if ($conn->errno != 0) {
		echo $conn->errno.'<br>';
		echo $sql.'<br>';
	}
}

$project_cnt = 1;
function getAllProjects($user_id, $page=1){
	global $api_key, $project_cnt;
	$url = "https://api.hackaday.io/v1/users/$user_id/projects?api_key=" . $api_key;
	$url .= "&page=".$page;

	$online_contents = file_get_contents($url);
	$test = json_decode($online_contents);
	$last_page = $test->last_page;

	if (is_object($test) && is_array($test->projects))
	{
		foreach ($test->projects as $project) {
			$db_project = get_project($project->id);
			if (is_object($db_project)){
				echo $project_cnt++ . ' ';
				echo 'Project found! ' . $project->id . '<br>';

			}
			else {
				add_project($project);
				echo 'added: ' . $project->id . '<br>';
			}
		}
	}
	if ($page < $last_page) getAllProjects($user_id, $page+1);
}

function getUserPages($user_id, $page=1){
	global $api_key;
	$url = "https://api.hackaday.io/v1/users/$user_id/pages?api_key=" . $api_key;
	$url .= "&page=".$page;

	$online_contents = file_get_contents($url);
	$test = json_decode($online_contents);
	$last_page = $test->last_page;

	foreach ($test->pages as $page_post) {
		add_page_post($page_post);
	}
	if ($page < $last_page) getUserPages($user_id, $page+1);
}

function add_page_post($post) {
	global $conn;

	$local_post = get_post($post->id, 'page');

	if (is_object($local_post)) {
		return;
	}

	$sql = "INSERT INTO posts (
               external_id,
               title,
               body,
               category,
               created
           ) VALUES";

	$sql.= "(";
	$sql.= $post->id . ', ';
	$sql.= '"'.$conn->escape_string($post->title) . '", ';
	$sql.= '"'.$conn->escape_string($post->body) . '", ';
	$sql.= '"page", ';
	$sql.= $post->created;
	$sql.= ")";

	$conn->query($sql);

	if ($conn->errno != 0) {
		echo $conn->errno.'<br>';
		echo $sql.'<br>';
	}
}

function getProjectLogs($project_id){
	global $api_key;
	$url = "https://api.hackaday.io/v1/projects/$project_id/logs?api_key=" . $api_key;

	$online_contents = file_get_contents($url);
	$test = json_decode($online_contents);

	if (!is_array($test->logs)) return;
	foreach ($test->logs as $post) {
		add_page_log($post);
	}
}

function add_page_log($post) {

	global $conn;

	$local_post = get_post($post->id, 'page');

	if (is_object($local_post)) {
		return;
	}

	$sql = "INSERT INTO posts (
               external_id,
               title,
               body,
               category,
               project_id,
               created
           ) VALUES";

	$sql.= "(";
	$sql.= $post->id . ', ';
	$sql.= '"'.$conn->escape_string($post->title) . '", ';
	$sql.= '"'.$conn->escape_string($post->body) . '", ';
	$sql.= '"log", ';
	$sql.= $post->project_id.', ';
	$sql.= $post->created;
	$sql.= ")";
	$conn->query($sql);

	if ($conn->errno != 0) {
		echo $conn->errno.'<br>';
		echo $sql.'<br>';
	}
}

