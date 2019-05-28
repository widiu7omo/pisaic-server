<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
    require './connection.php';
    $datarows = [];
    if(isset($_GET['data'])){
        $result = $conn->query("select * from $_GET[data]");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($datarows,$row);
            }
        }
    }
    if(isset($_GET['input'])){
        $post=$_POST;
        switch($_GET['input']){
            case 'users':
            $users = json_decode($post['users']);
            //retive headers
            // var_dump($users);
            foreach($users[0] as $key=> $heder){
                $columns[] = $key;
            }
            $joinedKey = join(',',$columns);
            // var_dump($joinedKey);
            //retrive values
            $values = '';
            foreach($users as $key=> $user){
                $values .= "( '$user->name', '$user->nrp', '$user->lahir')";
                if(sizeof($users) != $key+1){
                    $values .= ",";
                }
                
            }
            // var_dump($values);
            $query = "insert into users ($joinedKey) values $values";
            // var_dump($query);
            $conn->query($query) or die($conn->error);
            break;
            case 'units':
            break;
        }
        
        // $columns = array_keys($post);
        // $values = array_map(function($input) use ($post){
        //     return '"'.$post[$input].'"';
        // },$columns);
        // $joinedValues = join(',',$values);
        // $joinedColumns = join(',',$columns);
        // $query = "insert into $_GET[input] ($joinedColumns) values($joinedValues)";
        // $conn->query($query) or die($conn->mysqli_error());
    }

    
    echo json_encode($datarows);
?>