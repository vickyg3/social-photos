<?

require_once(dirname(dirname(__FILE__)) . "/social_network.php");

function open_db() {
    // actual username and passwords are filled up in production deployment
    return pg_connect(Config::get("db_string"));
}

function close_db($db) {
    pg_close($db);
}

function run_query($query) {
    // if log is set to false, this is a no-op.
    if (Config::get("log") == "true") {
        $db = open_db();
        pg_query($db, $query);
        close_db($db);
    }
}

function log_transfer($src, $dst, $size) {
    $src = intval($src);
    $dst = intval($dst);
    $url = pg_escape_string($url);
    $query = "INSERT into transfers (src, dst, size) VALUES ($src, $dst, $size);";
    run_query($query);
}

function log_api_call($network, $type, $time_taken) {
    $network = intval($network);
    $type = pg_escape_string($type);
    $time_taken = intval($time_taken);
    $query = "INSERT into api_calls (network, type, time_taken) VALUES ($network, '$type', $time_taken);";
    run_query($query);
}

// Takeout DB helper functions

function add_takeout_job($job) {
    $job_str = pg_escape_string(json_encode($job));
    $query = "INSERT INTO takeout_jobs_raw (job) VALUES ('{$job_str}');";
    run_query($query);
}

// End of Takeout DB helper functions

?>
