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

try {
    $project_id = NULL;
    $project_categories = array(
        'audio',
        'badgelife',
        'breakout',
        'clocks',
        'displays',
        'experiments',
        'feather',
        'handhelds',
        'home automation',
        'howto',
        'LED art',
        'misc',
        'props',
        'robots',
        'sewing',
        'software',
        'tools',
        'no_category'
    );
    echo '<div class="content">';
    echo '<a href="projects.php">all</a>';
    foreach ($project_categories as $project_category){
        echo ' | ';
        echo '<a href="projects.php?category=' . $project_category . '">';
        echo $project_category;
        echo '</a>';

    }
    echo '</div>';

    if (isset($_GET['category']) && in_array($_GET['category'], $project_categories)){
        $local_projects = get_local_projects($_GET['category']);
        display_projects($local_projects);
    }
    else if (isset($_GET['project']))
    {
        $project_id = intval($_GET['project']);
        // getProjectLogs($project_id);

        $project = get_project($project_id);
        $local_posts = get_local_posts('all', $project_id);
        // print_r($project);
        echo '<div class="content">';
        echo '<h1>' . $project->name . '</h1>';
        echo $project->summary;
        echo '<br>';

        echo '<img src="';
        echo isset($project->image_url)?$project->image_url:"https://cdn.hackaday.io/images/7238271475338252094.png";
        echo '">';
        echo '<br>';
        if (trim($project->summary) != trim($project->description)){
            echo $project->description;
            echo '<br>';
        }
        echo '</div>';

        display_posts($local_posts);

    }
    else {
        $local_projects = get_local_projects();
        display_projects($local_projects);
    }
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

    .project {
        display: inline-block;
    }

    .project_title {
        /*position: absolute;*/
        width:320px;
        height:120px;
    }

    .projects_gallery {
        width: 320px;
        height: 320px;
        object-fit: cover;
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