<?php
    require_once("connect.php");

/************************************************
 * fonction pour préparer un string à partir d'un tableau
 ************************************************/
    function prepare_string($champ, $type = 1){
        $valeurs = [];
        if(associative_array($champ) != 0){
            foreach($champ as $champ_key=>$champ_value){
                $valeurs[] = $champ_key ." = '". $champ_value."'";
            }
        }else{
            foreach($champ as $where){
                $valeurs[] = $where;
            }
        }

        if($type == 1)
            return implode(', ', $valeurs);
        if($type == 2)
            return implode(' AND ', $valeurs);
        if($type == 3)
            return implode(' OR ', $valeurs);
    }


/************************************************
 * fonction pour réaliser la jointure entre les tables de la base se donnés
 ************************************************/
    function prepare_join($join_table){
        $valeurs = [];
        foreach($join_table as $join){
            $valeurs[] = $join;
        }
        return implode(' ', $valeurs);
    }


/************************************************
 * fonction pour vérifier l'authentification
 ************************************************/
    function login($table, $wheres){
        global $mysqli;
        $sql = "SELECT * FROM $table WHERE ".prepare_string($wheres, 2);
        return mysqli_query($mysqli, $sql);
    }


/************************************************
 * fonction pour ajouter des donnés à la table randonnées
 ************************************************/
    function ajouter($nom_table, $champs){
        global $mysqli;
        $sql = "INSERT INTO $nom_table SET " . prepare_string($champs, 1);
        //die($sql) ;
    
        if($mysqli->query($sql))
            return mysqli_insert_id($mysqli);
    }


/************************************************
 * fonction pour consulter les donnés
 ************************************************/
    function consulter($valeur_saisi, $offset = null, $total_records_per_page = null, $id=null, $order=null){
        global $mysqli;
        if($order === null){
            $order = 'id_randonnes ASC';
        }
        if(is_array($valeur_saisi)){
            if($id != null)
                $sql = "SELECT * FROM ". prepare_join($valeur_saisi)." WHERE randonnees.id_randonnes = $id";
            else if($offset !== null && $total_records_per_page !== null)
                $sql = "SELECT * FROM ". prepare_join($valeur_saisi)." ORDER BY ".$order." LIMIT $offset,  $total_records_per_page";
            else
                $sql = "SELECT * FROM ". prepare_join($valeur_saisi);

        }else if($offset!== null && $total_records_per_page!== null){
            $sql = "SELECT * FROM $valeur_saisi ORDER BY ".$order." LIMIT $offset, $total_records_per_page";
        }else
            $sql = "SELECT * FROM $valeur_saisi";
        return mysqli_query($mysqli, $sql);

    }


/************************************************
 * fonction pour préparer le string de where pour rechecher
 ************************************************/
    function prepare_wheres_recherche($wheres, $type_recherche){
        if($type_recherche == 'simple'){
            return prepare_string($wheres, 3);
        }

        if($type_recherche == 'avancee')
            return prepare_string($wheres, 2);

    }


/************************************************
 * fonction pour modifier des donnés
 ************************************************/
    function modifier($nom_table, $champs, $id){
        global $mysqli;
        $sql = "UPDATE $nom_table SET " . prepare_string($champs) . " WHERE id_randonnes = $id";
        return $mysqli->query($sql);
    }


/************************************************
 * fonction pour supprimer des donnés
 ************************************************/
    function supprimer($nom_table, $id){
        global $mysqli;
        $sql = "DELETE FROM $nom_table WHERE id_randonnes = $id";
        return $mysqli->query($sql);
    }

    function supprimer_contact($nom_table, $id){
        global $mysqli;
        $sql = "DELETE FROM $nom_table WHERE id = $id";
        return $mysqli->query($sql);
    }


/************************************************
 * fonction pour rechercher des donnés
 ************************************************/
    function recherche($join_arr, $offset, $total_records_per_page, $wheres, $type_recherche, $order = null){
        global $mysqli, $pagination;
        if($order === null){
            $order = 'id_randonnes ASC';
        }

        $sql = "SELECT * FROM ".prepare_join($join_arr)." WHERE ".prepare_wheres_recherche($wheres, $type_recherche)
            ." ORDER BY ".$order." LIMIT $offset, $total_records_per_page";

        $sql_query = "SELECT * FROM ".prepare_join($join_arr)." WHERE ".prepare_wheres_recherche($wheres,
                $type_recherche);
        $pagination = pagination(mysqli_query($mysqli, $sql_query));
        return mysqli_query($mysqli, $sql);
    }
