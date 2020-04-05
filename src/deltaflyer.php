<?php
namespace Rhiaro;

use Requests;
use EasyRdf_Graph;
use EasyRdf_Literal;
use ML\JsonLD\JsonLD;

function make_tags($input_array){
    $base = "https://rhiaro.co.uk/tags/";
    $tags_string = $input_array["string"];
    unset($input_array["string"]);
    $tags = explode(",", $tags_string);
    foreach($tags as $tag){
        $input_array[] = $base.urlencode(trim($tag));
    }
    return $input_array;
}

function make_date($date_parts){
    $date_str = $date_parts["year"]."-".$date_parts["month"]."-".$date_parts["day"]."T".$date_parts["time"].$date_parts["zone"];
    $date = new EasyRdf_Literal($date_str, null, "xsd:dateTime");
    return $date;
}

function make_location_from_string($location){

}

function make_location_from_coords($coords){
    
}

function make_payload($form_request){
    global $ns;
    $g = new EasyRdf_Graph();
    
    $published_date_parts = [
        "year" => $form_request["year"],
        "month" => $form_request["month"],
        "day" => $form_request["day"],
        "time" => $form_request["time"],
        "zone" => $form_request["zone"],
    ];
    $published_date = make_date($published_date_parts);

    $start_date_parts = [
        "year" => $form_request["startyear"],
        "month" => $form_request["startmonth"],
        "day" => $form_request["startday"],
        "time" => $form_request["starttime"],
        "zone" => $form_request["startzone"],
    ];
    $start_date = make_date($start_date_parts);

    $end_date_parts = [
        "year" => $form_request["endyear"],
        "month" => $form_request["endmonth"],
        "day" => $form_request["endday"],
        "time" => $form_request["endtime"],
        "zone" => $form_request["endzone"],
    ];
    $end_date = make_date($end_date_parts);
    
    $tags = make_tags($form_request["tags"]);

    $node = $g->newBNode();
    $g->addType($node, "as:Travel");
    $g->addLiteral($node, "as:published", $published_date);
    $g->addLiteral($node, "as:startTime", $start_date);
    $g->addLiteral($node, "as:endTime", $end_date);
    foreach($tags as $tag){
        $g->addResource($node, "as:tag", $tag);
    }
    $jsonld = $g->serialise("jsonld");

    $context = $ns->get("as");
    $options = array("compactArrays" => true);
    $compacted = JsonLD::compact($jsonld, $context, $options);

    echo $g->dump();

    return JsonLD::toString($compacted, true);
}

function post_to_endpoint($form_request){
    $endpoint = $form_request["endpoint_uri"];
    $key = $form_request["endpoint_key"];
    $headers = array("Content-Type" => "application/ld+json", "Authorization" => $key);
    $payload = make_payload($form_request);
    // $response = Requests::post($endpoint, $headers, $payload);
    // return $response;
    return $payload;
}

?>