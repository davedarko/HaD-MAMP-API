<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

try {
    // /error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


    $servername = 'server_host_address';
    $username = 'server_host_user_name';
    $password = 'server_host_user_password';
    $database = 'server_host_database_name';

    $conn = new mysqli ($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    include "hackadayAPI.php";
    include "localProjects.php";
}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo '<html>';
echo '<head>';

echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<meta charset="utf-8">';
echo '<link rel="icon" type="image/png" href="img/icon.png">';
echo '<link rel="apple-touch-icon" type="image/png" href="img/icon.png">';

echo '</head>';
echo '<body>';

$post_stats = get_post_stats();
if (is_array($post_stats)){
    echo '<table>';

    echo '<tr>';
    foreach ($post_stats as $post_stat) {
        if (!is_object($post_stat)) continue;

        echo '<th>';
        echo $post_stat->year;
        echo '</th>';
    }
    echo '</tr>';

    echo '<tr>';
    foreach ($post_stats as $post_stat) {
        if (!is_object($post_stat)) continue;

        echo '<td>';
        echo $post_stat->cnt;
        echo '</td>';
    }
    echo '</tr>';

    echo '</table>';
}

try {

    /*

    https://api.hackaday.io/v1/users/YOUR_USER_ID/pages?api_key=YOUR_API_KEY
    "pages": [
    {
      "id": 13822,
      "user_id": YOUR_USER_ID,
      "title": "getting the pico usb host example compiled correctly",
      "body": "",
      "url": null,
      "meta": null,
      "created": 1669924284
    },

    id, external_id, title, body, category, project_id, created

    https://api.hackaday.io/v1/users/YOUR_USER_ID/pages?api_key=YOUR_API_KEY
    project data
    [29] => stdClass Object
    (
        [id] => 67508
        [project_id] => 26823
        [user_id] => YOUR_USER_ID
        [title] => That is just the perfect color!
        [body] => 
        [category] => log
        [meta] => 
        [created] => 1505908234
    )

    */
    $project_id = NULL;
    if (isset($_GET['project']))
    {
        $project_id = intval($_GET['project']);
        getProjectLogs($project_id);
    }

//  $local_projects = get_local_projects();
//  if (is_array($local_projects)){
//      foreach ($local_projects as $local_project) {
//            if (!is_object($local_project)) continue;
//
//          echo '<a href="?project='.$local_project->id.'">';
//          if ( $local_project->id == $project_id) echo '==> ';
//          echo $local_project->id;
////            echo '<img'
////            .' src="'.$local_project->image_url.'"'
////            .' title="['.$local_project->id . "] " . $local_project->name.'"'
////            .'>';
//          echo '</a><br>';
//
//          if (!isset($local_project->id)) {
//              print_r($local_project);
//          }
//      }
//  }

    $local_posts = get_local_posts();
    display_posts($local_posts);
}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


if (true) {
    global $user_id;
    // getAllProjects($user_id);

    // this imports pages
    // getUserPages($user_id);

}


echo '</body>';
echo '</html>';
?>

<style>

/* latin-ext */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 300;
    src: local('Raleway Light'), local('Raleway-Light'), url(fonts/1Ptrg8zYS_SKggPNwIYqWqhPANqczVsq4A.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 300;
    src: local('Raleway Light'), local('Raleway-Light'), url(fonts/1Ptrg8zYS_SKggPNwIYqWqZPANqczVs.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* latin-ext */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    src: local('Raleway'), local('Raleway-Regular'), url(fonts/1Ptug8zYS_SKggPNyCMIT4ttDfCmxA.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    src: local('Raleway'), local('Raleway-Regular'), url(fonts/1Ptug8zYS_SKggPNyC0IT4ttDfA.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* latin-ext */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 600;
    src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url(fonts/1Ptrg8zYS_SKggPNwPIsWqhPANqczVsq4A.woff2) format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 600;
    src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url(fonts/1Ptrg8zYS_SKggPNwPIsWqZPANqczVs.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

html { font-size: 1.1em; }
body {
    background-color: #222;
    color: #FFF;
    font-family: Raleway, HelveticaNeue, "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 400;
}

h1, h2, h3, h4, h5, h6 {
    margin-top: 3rem;
    font-weight: 300;
}

a {
    color: #F06;
    font-size: 0.8em;
}

pre{
    font-size: 0.8em;
}

.post {
    border-top: #F06 solid 2px;
    border-bottom: mediumpurple solid 2px;
    background-color: #282828;
    padding: 12px;
}
img {
    width: 30%;
    display: inline;
}
video, table {
    width: 80%;
}
table, tr, th, td {
    border: mediumpurple solid 1px;

}
table, .content {
    position: relative;
    max-width: 960px;
    margin: 0 auto;
    width: 80%;
}


@media only screen and (max-width: 600px) {
    .navi_title {
        display: inline-block;
    }

    .navi ul {
        display:none;
    }
    img {
        width: 100%;
    }
    video, table, .content {
        width: 100%;
    }
    pre {
        overflow-x: scroll;
    }

    table {
        font-size: 0.8em;
    }
}
    
</style>