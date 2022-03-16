<?php

class Response
{
    public static function getResponses($sort = "date", $offset = 0){
        $db = DB::getConnection();

        if($sort == "date"){ $sort = "date DESC ";}
        if($offset != 0){ $offset = " OFFSET " . $offset;}else{ $offset = "";}

        $sql = "SELECT * FROM response ORDER BY ". $sort ." LIMIT 5 " . $offset;

        $result = $db->query($sql);

        $responses = array();

        $i = 0;
        while($row = $result->fetch()){
            $responses[$i]['id'] = $row['id'];
            $responses[$i]['name'] = $row['name'];
            $responses[$i]['email'] = $row['email'];
            $responses[$i]['message'] = $row['message'];
            $responses[$i]['date'] = $row['date'];
            $i++;
        }

        return $responses;
    }

    public static function addResponse($name, $email, $message, $date){
        $db = DB::getConnection();

        $sql = "INSERT INTO response VALUES (NULL, :name, :email, :message, :date)";

        $result = $db->prepare($sql);

        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':message', $message, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);

        $result->execute();

        return true;
    }

    public static function editResponse($id, $message){
        $db = DB::getConnection();

        $sql = "UPDATE response SET message = :message WHERE id = :id";

        $result = $db->prepare($sql);

        $result->bindParam(':message', $message, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->execute();

        return true;
    }

    public static function deleteResponse($id){
        $db = DB::getConnection();

        $sql = "DELETE FROM response WHERE id = :id";
        $result = $db->prepare($sql);

        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->execute();

        return true;

    }
}