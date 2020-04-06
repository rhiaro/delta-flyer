<?php
namespace Rhiaro;

use Requests;
use EasyRdf_Graph;
use EasyRdf_Literal;
use ML\JsonLD\JsonLD;
use GeoNames\Client as GeoNamesClient;

// Form input processing

function make_tags($input_array){
    $base = "https://rhiaro.co.uk/tags/";
    $tags_string = $input_array["string"];
    unset($input_array["string"]);
    $tags = explode(",", $tags_string);
    foreach($tags as $tag){
        if(strlen(trim($tag)) > 0){
            $input_array[] = $base.urlencode(trim($tag));
        }
    }
    return $input_array;
}

function make_date($date_parts){
    $date_str = make_date_string($date_parts);
    $date = new EasyRdf_Literal($date_str, null, "xsd:dateTime");
    return $date;
}

function make_date_string($date_parts){
    $date_str = $date_parts["year"]."-".$date_parts["month"]."-".$date_parts["day"]."T".$date_parts["time"].$date_parts["zone"];
    return $date_str;
}

function extract_coords($coords_str){
    $coords = explode(",", $coords_str);
    return $coords;
}

function make_location_from_string($location){
    $base = "https://rhiaro.co.uk/location/";
    $is_uri = stripos($location, "http");
    if($is_uri !== false){
        return $location;
    }else{
        return $base.urlencode(trim($location));
    }
}

function make_location_from_coords($lat, $lng, $name){
    $location_graph = new EasyRdf_Graph();
    $location_node = $location_graph->newBNode();
    $location_graph->addType($location_node, "as:Place");
    $location_graph->addLiteral($location_node, "as:name", $name);
    $location_graph->addLiteral($location_node, "as:latitude", number_format((float) $lat, 4));
    $location_graph->addLiteral($location_node, "as:longitude", number_format((float) $lng, 4));
    return $location_graph;
}

function validate_input($form_request){
    if(isset($form_request["startlat"]) && isset($form_request["startlng"])){
        $startcoords = $form_request["startlat"].",".$form_request["startlng"];
    }
    if(isset($form_request["endlat"]) && isset($form_request["endlng"])){
        $endcoords = $form_request["endlat"].",".$form_request["endlng"];
    }
    
    if((!isset($form_request["from"]) || strlen(trim($form_request["from"])) < 1) 
        && (!isset($startcoords) && strlen(trim($startcoords)) < 1)){
        return false;
    }
    if((!isset($form_request["to"]) || strlen(trim($form_request["to"])) < 1)
        && (!isset($endcoords) || strlen(trim($startcoords)) < 1)){
        return false;
    }
    if(isset($form_request["to"]) && isset($form_request["from"]) && $form_request["to"] == $form_request["from"]){
        return false;
    }
    if(isset($startcoords) && isset($endcoords) && $startcoords == $endcoords){
        return false;
    }
    $dates = process_dates($form_request);
    if($dates["start"] == $dates["end"]){
        return false;
    }
    return true;
}

function process_dates($form_request){
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

    $dates = [
        "published" => $published_date,
        "start" => $start_date,
        "end" => $end_date
    ];

    return $dates;
}

function make_payload($form_request){
    global $ns;
    $g = new EasyRdf_Graph();
    $context = $ns->get("as");
    $options = array("compactArrays" => true);

    $endpoint = $form_request["endpoint_uri"];
    $key = $form_request["endpoint_key"];
    
    $dates = process_dates($form_request);

    if(isset($form_request["from"]) && strlen($form_request["from"]) > 0){
        $from_location = make_location_from_string($form_request["from"]);
    }
    if(isset($form_request["to"]) && strlen($form_request["to"]) > 0){
        $to_location = make_location_from_string($form_request["to"]);
    }

    if(isset($form_request["startlat"]) && isset($form_request["startlng"])){
        $start_location = make_location_from_coords($form_request["startlat"], $form_request["startlng"], $form_request["startname"]);
        // echo $start_location->dump();
        // HERENOW post start_location to endpoint and get URL back
        
        $startjsonld = $start_location->serialise("jsonld");
        $start_comp = JsonLD::compact($jsonld, $context, $options);
        $start_payload = JsonLD::toString($start_comp, true);
        // $from_url = post_to_endpoint($endpoint, $key, $start_payload);
    }
    if(isset($form_request["endlat"]) && isset($form_request["endlng"])){
        $end_location = make_location_from_coords($form_request["endlat"], $form_request["endlng"], $form_request["endname"]);
        // echo $end_location->dump();
    }
    
    $tags = make_tags($form_request["tags"]);
    $summary = trim($form_request["summary"]);
    $content = trim($form_request["content"]);

    if(validate_input($form_request)){

        $node = $g->newBNode();
        $g->addType($node, "as:Travel");
        $g->addLiteral($node, "as:published", $dates["published"]);
        $g->addLiteral($node, "as:startTime", $dates["start"]);
        $g->addLiteral($node, "as:endTime", $dates["end"]);
        if(isset($from_location)){
            $g->addResource($node, "as:origin", $from_location);
        }
        if(isset($to_location)){
            $g->addResource($node, "as:target", $to_location);
        }
        foreach($tags as $tag){
            $g->addResource($node, "as:tag", $tag);
        }
        if(strlen($summary) > 0){
            $g->addLiteral($node, "as:summary", $summary);
        }
        if(strlen($content) > 0){
            $g->addLiteral($node, "as:content", $content);
        }

        $jsonld = $g->serialise("jsonld");
        $compacted = JsonLD::compact($jsonld, $context, $options);

        echo $g->dump();

        return JsonLD::toString($compacted, true);
    }else{
        return false;
    }
}

function form_to_endpoint($form_request){
    $endpoint = $form_request["endpoint_uri"];
    $key = $form_request["endpoint_key"];
    $payload = make_payload($form_request);
    $response = post_to_endpoint($endpoint, $key, $payload);
    // return $response;
    return $payload;
}

function post_to_endpoint($endpoint, $key, $payload){
    $headers = array("Content-Type" => "application/ld+json", "Authorization" => $key);
    // $response = Requests::post($endpoint, $headers, $payload);
    // return $response;
}

?>