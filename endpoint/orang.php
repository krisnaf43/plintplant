<?php
    require_once( 'sparqlib.php' );

    $db = sparql_connect( "http://localhost:3030/orang/query" );
    if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
    
    sparql_ns("dbo", "http://dbpedia.org/ontology/#");
    sparql_ns("dc", "http://purl.org/dc/elements/1.1#");
    sparql_ns("wo", "https://www.bbc.co.uk/ontologies/wo#");
    
    $sparql = "
        prefix rdf:   <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
        prefix bio:   <http://purl.org/vocab/bio/0.1/> 
        prefix foaf:  <http://xmlns.com/foaf/0.1/> 
        prefix dc:    <http://purl.org/dc/elements/1.1/> 
        
        SELECT ?position ?name
        WHERE{
                ?x bio:position ?position.
                ?x foaf:name ?name.
                FILTER((?position = 'Wakil Rektor III') || (?position = 'Rektor')).
        }	
    ";
    $name = [];
    $result = sparql_query( $sparql ); 
    while($row = sparql_fetch_array( $result )){
        if($row['position'] == "Rektor"){
            $name[0] = $row['name'];
            $name[1] = $row['position'];
        } else{
            $name[2] = $row['name'];
            $name[3] = $row['position'];
        }
    }
    echo '<p class="lead ml-0 pl-0 " style="text-align: center">Diresmikan oleh ';
    echo $name[0].' ('.$name[1];
    echo ') dan ';
    echo $name[2].' ('.$name[3].')';
    echo '</p>';

?>