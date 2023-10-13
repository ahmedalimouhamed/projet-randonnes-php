<?php

$total_records_per_page = 6; //total des enregistrements par page
$total_no_of_pages = null; //total nombre des pages


/************************************************
 * fonction pour obtenir le numéro de page de l'url et le retourner
 ************************************************/

function get_page_no(){
    if(isset($_GET['page_no']) && !empty($_GET['page_no'])){
        $page_no = $_GET['page_no'];
    }else{
        $page_no = 1;
    }
    return $page_no;
}


/************************************************
 * fonction pour calculer et retourner le nombre total des page
 ************************************************/
function total_number_of_pages($total_records_per_page, $total_records){
    return ceil($total_records / $total_records_per_page);
}


/************************************************
 * fonction pour calculer et retourner l'offset
 ************************************************/
function get_offset(){
    global $total_records_per_page;
    $page_no = get_page_no();
    return ($page_no-1) * $total_records_per_page;
}


/************************************************
 * fonction pour détérminner les pages
 ************************************************/
function pages(){
    global $total_records_per_page, $total_no_of_pages;
    $page_no = get_page_no();
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $offset = get_offset();
    $second_last = $total_no_of_pages - 1;

    return [
        'page_no'=>$page_no,
        'offset' => $offset,
        'total_records_per_page'=> $total_records_per_page,
        'previous_page'=> $previous_page,
        'next_page'=> $next_page,
        'total_no_of_pages' => $total_no_of_pages,
        'second_last' => $second_last
    ];

}


/************************************************
 * fonction pour réaliser la pagination
 ************************************************/
function pagination($sql_query = null){
    global $total_records_per_page, $mysqli, $total_no_of_pages;
    if($sql_query === null){
        $sql_query = mysqli_query($mysqli, "SELECT * FROM randonnees");
    }
    $num_rows = $sql_query->num_rows;
    $total_no_of_pages = total_number_of_pages($total_records_per_page, $num_rows);
    pages()['total_no_of_pages'] = $total_no_of_pages;
    return pages();
}