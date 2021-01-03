<?
session_start();
require 'vendor/autoload.php';
$ns = Rhiaro\ns();

$tz = Rhiaro\get_timezone_from_rdf("https://rhiaro.co.uk/tz");
date_default_timezone_set($tz);

// if(isset($_POST['locations_source'])){
//     $locations = Rhiaro\get_locations($_POST['locations_source']);
// }elseif(isset($_SESSION['locations'])){
//     $locations = $_SESSION['locations'];
// }else{
//     $locations = Rhiaro\set_default_locations();
// }

$tags = array(
    "travel" => "https://rhiaro.co.uk/tags/travel",
    "transit" => "https://rhiaro.co.uk/tags/transit",
    "tram" => "https://rhiaro.co.uk/tags/tram",
    "ferry" => "https://rhiaro.co.uk/tags/ferry",
    "bus" => "https://rhiaro.co.uk/tags/bus",
    "train" => "https://rhiaro.co.uk/tags/train",
    "metro" => "https://rhiaro.co.uk/tags/metro",
    "hiking" => "https://rhiaro.co.uk/tags/hiking",
    "car" => "https://rhiaro.co.uk/tags/car",
    "taxi" => "https://rhiaro.co.uk/tags/taxi",
    "plane" => "https://rhiaro.co.uk/tags/plane",
    "hitchhiking" => "https://rhiaro.co.uk/tags/hitchhiking",
);

$locations = Rhiaro\get_locations();

usort($locations, function($a, $b) {
    return $a['sort'] <=> $b['sort'];
});

if(isset($_POST['submit'])){
    if(isset($_POST['endpoint_key'])){
        $_SESSION['key'] = $_POST['endpoint_key'];
    }
    $endpoint = $_POST['endpoint_uri'];
    $result = Rhiaro\form_to_endpoint($_POST);
    if(!is_array($result) && $result->status_code == "201"){
        unset($_POST);
    }
}

include('templates/index.php');
?>