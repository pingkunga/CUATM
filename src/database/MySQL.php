<?php namespace Database;
    use mysqli;
    class MySQL
    {
        private $servername = "203.146.44.187";
        private $username = "user";
        private $password = "admin@1234";
        private $dbName = "cu_bank";
    
        public function query(string $queryString){
            $response = array("isError" => false
                            , "message" => ''
                            , "description" => ''
                            , "data" => array());

            $conn = mysqli_connect($this->servername,$this->username,$this->password,$this->dbName);
            if(!$conn)
            {
                $response["isError"] = true;
                $response["message"] = "connection error";
                $response["description"] = mysqli_error($conn);
                return $response;
            }
            $result = mysqli_query($conn,$queryString);

            if(mysqli_error($conn))
            {
                $response["isError"] = true;
                $response["message"] = "query error";
                $response["description"] = mysqli_error($conn);
            }
            else
            {
                $data = array("count" => 0, "records" => array());
                $data["count"] = mysqli_num_rows($result);
        
                for($ct = $data["count"];$ct > 0;$ct--){
                    array_push($data["records"], mysqli_fetch_array($result,MYSQLI_ASSOC));
                }
                $response["data"] = $data;
            }
            mysqli_close($conn);
            return $response;
        }

        public function escapeString($value): string
        {
            $conn = mysqli_connect($this->servername,$this->username,$this->password,$this->dbName);
            return mysqli_real_escape_string($conn,$value);
        }

        public function execute(string $queryString){
            $response = array("isError" => false
                            , "message" => ''
                            , "description" => ''
                            , "data" => array());
                            
            $conn = mysqli_connect($this->servername,$this->username,$this->password,$this->dbName);
            if(!$conn)
            {
                $response["isError"] = true;
                $response["message"] = "connection error";
                $response["description"] = mysqli_error($conn);
                return $response;
            }
            mysqli_query($conn,$queryString);
            $affectedRow = $conn->affected_rows; 

            if(mysqli_error($conn))
            {
                $response["isError"] = true;
                $response["message"] = "execute error";
                $response["description"] = mysqli_error($conn);
            }
            else
            {
                $data = array("count" => 0, "records" => array());
                $data["count"] = $affectedRow;
                $response["data"] = $data;
            }
            mysqli_close($conn);
            return $response;
        }
        
    }
?>