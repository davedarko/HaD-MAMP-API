<?php
// localProjects.php


function get_local_projects($project_category = 'all') {
	global $conn;

		$sql_additional = '';
		if ($project_category == 'no_category') {
			$sql_additional = " AND project_category = '' ";
		}
		else if ($project_category != 'all') {
			$sql_additional = " AND project_category LIKE '%$project_category%' ";
		}
	$sql = "SELECT * 
		FROM projects
		WHERE 1
		$sql_additional
		ORDER BY created DESC";
	$result = $conn->query($sql);

	$results = array();
	if ($result->num_rows > 0) {

		while($results[] = $result->fetch_object());
	}

	return $results;
}

function get_project($id) {
	global $conn;

	$sql = "SELECT * FROM projects WHERE id = $id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		return $result->fetch_object();
	}

	return 0;
}

function get_post($external_id, $category) {
	global $conn;

	$sql = "SELECT * FROM posts WHERE category = '$category' AND external_id = '$external_id'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		return $result->fetch_object();
	}

	return 0;
}

function get_local_posts($category = 'all', $project_id = 0, $limit_start=0, $limit_amount=20) {
	global $conn;

	$sql_add = '';
	if ($category != 'all') {
		$sql_add .= "AND category = '$category' ";
	}

	if ($project_id > 0) {
		$sql_add .= "AND project_id = $project_id ";
	}

	$sql = "SELECT *, posts.created AS post_created
		FROM posts
		LEFT JOIN projects
		ON posts.project_id = projects.id
		WHERE 1
		$sql_add
		ORDER BY posts.created DESC
		LIMIT $limit_start, $limit_amount
	";
	$result = $conn->query($sql);

	$results = array();
	if ($result->num_rows > 0) {

		while($results[] = $result->fetch_object());
	}

	return $results;
}

function get_post_stats() {
	global $conn;

	$sql = "SELECT 
		YEAR(DATE_ADD('1970-01-01 00:00:00', INTERVAL created SECOND)) as year,
		COUNT(created) as cnt
		FROM `posts`
		GROUP BY YEAR(DATE_ADD('1970-01-01 00:00:00', INTERVAL created SECOND))
		ORDER BY created DESC
		";

	$result = $conn->query($sql);

	$results = array();
	if ($result->num_rows > 0) {

		while($results[] = $result->fetch_object());
	}

	return $results;

}

function display_posts($local_posts) {
	if (!is_array($local_posts)) return;

	echo '<div class="content">';
	foreach ($local_posts as $local_post){
		if (!is_object($local_post)) continue;

		echo '<h2>';
		if (isset($local_post->name)) {
			echo $local_post->name;
			echo ' | ';
		}
		echo $local_post->title;
		echo '</h2>';
		echo '<div class="post">';
		echo date("Y-m-d H:i:s", $local_post->post_created);
		echo '<br>';


		echo str_replace('data-src', 'src', $local_post->body);

		$doc = new DOMDocument();
		@$doc->loadHTML($local_post->body);

		$tags = $doc->getElementsByTagName('img');

		foreach ($tags as $tag) {
			echo $tag->getAttribute('data-src');
			echo '<br>';
		}
		echo '</div>';
	}
	echo '</div>';
}

function display_projects($local_projects){
	if (!is_array($local_projects)) return;

	echo '<div class="content">';
	foreach ($local_projects as $local_project) {
		if (!is_object($local_project)) continue;

		$image_url = !empty($local_project->image_url)
			?$local_project->image_url
			:"https://cdn.hackaday.io/images/7238271475338252094.png";

		echo '<div class="project">';
		echo '<a href="?project='.$local_project->id.'">';
		echo '<img'
			.' src="'.$image_url.'"'
			.' class="projects_gallery"'
			.' title="['.$local_project->id . "] " . $local_project->name.'"'
			.'>';
		echo '</a>';

		echo '</div>';


		if (!isset($local_project->id)) {
			print_r($local_project);
		}
	}
	echo '</div>';
}