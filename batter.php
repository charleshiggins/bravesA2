<?php
global $db;
$path_components = explode('/', $_SERVER['PATH_INFO']);
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $returnObj = array();
    $returnObj = getResults(strval($path_components[1]));
    echo json_encode($returnObj);
    exit();
}


function connectToDB() {
    global $db;
    try {
        $db = new PDO('sqlite:bravesDatabase.db'); 
    } 
    catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        $db = null;   
        exit();
    }
} 

function getResults($batter){
    global $db;
    connectToDB(); 
    $sql = "Select (SELECT COUNT(*) FROM BattedBallData WHERE Batter = '" . $batter . "' and PLAY_OUTCOME = 'Single') as singles, (SELECT COUNT(*) FROM BattedBallData WHERE Batter = '" . $batter . "' and PLAY_OUTCOME = 'Double') as doubles, (SELECT COUNT(*) FROM BattedBallData WHERE Batter = '" . $batter . "' and PLAY_OUTCOME = 'Triple') as triple, (SELECT COUNT(*) FROM BattedBallData WHERE Batter = '" . $batter . "' and PLAY_OUTCOME = 'HomeRun') as homeRuns, (SELECT COUNT(*) FROM BattedBallData WHERE Batter = '" . $batter . "' and PLAY_OUTCOME = 'Out') as outs, (Select AVG(cast(HIT_DISTANCE as INTEGER)) FROM BattedBallData WHERE Batter = '" . $batter . "' ) as dist from BattedBallData where Batter = '" . $batter . "'"; 
    $res = $db->prepare($sql);
    $res->execute();
    $result = $res->fetch();
    return $result;
}

?>