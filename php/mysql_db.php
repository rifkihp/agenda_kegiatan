<?php
    session_start();

    class mysql_db{

        var $session_name;
        var $db_host;
        var $db_port;
        var $db_user;
        var $db_pass;
        var $field;
        var $db_name;
        var $tabelDB ;
        var $fieldArr;

        public function mysql_db() {
            session_start();
            
            $this->db_host = DB_HOST;
            $this->db_port = DB_PORT;
            $this->db_user = DB_USER;
            $this->db_pass = DB_PASSWORD;
            $this->db_name = DB_DATABASE;
        }

        public function mysql_connect() {
            $this->conn = mysqli_connect($this->db_host.":".$this->db_port, $this->db_user, $this->db_pass, $this->db_name);
            if($this->conn) {
                return $this->conn;
            }
            
            die("Kesalahan melakukan koneksi database!");
        }

        public function mysql_close() {
            $return = mysqli_close($this->conn);
            unset($this->conn);

            return $return;
        }

        public function mysql_query($sql, &$rec_count, &$data) {
            //echo($sql."<br />");
            $result = mysqli_query($this->conn, $sql);

            if ($result ) {
                $rec_count = mysqli_num_rows($result);
                $data = array();

                if ($rec_count > 0) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        array_push($data, $row);
                    }
                }

                //print_r($data);
                
                mysqli_free_result($result);
                unset($result);

                return true;
            }

            $this->mysql_getError(mysqli_error($this->conn));
        }

        public function mysql_execute($sql) {
            //echo($sql);
            $result = mysqli_query($this->conn, $sql);
            //die("ERE ".$result);
            if($result==0) {
                $this->mysql_getError(mysqli_error($this->conn));
            } 
            
            return mysqli_affected_rows($this->conn);
        }

        public function mysql_insert($tabel, $data=array(), $escapequote=array()) {
            $query = "INSERT INTO $tabel SET ";
            
            foreach($data as $item => $value )
                $query .= "$item=".(array_search($item, $escapequote)!==false?mysqli_real_escape_string($this->conn, $value):"'".mysqli_real_escape_string($this->conn, $value)."'").",";
            $query = rtrim($query, ",");
            //echo($query);
            $this->mysql_execute($query);
        }

        public function mysql_update($tabel, $data=array(), $seleksi=array(), $escapequote=array(), $seleksi_escapequote=array()) {

            $query = "UPDATE $tabel SET " ;
            foreach($data as $item => $value)
                $query .= "$item=".(array_search($item, $escapequote)!==false?mysqli_real_escape_string($this->conn, $value):"'".mysqli_real_escape_string($this->conn, $value)."'").",";

            $query = rtrim($query, ",").(count($seleksi)>0?" WHERE ":"");

            foreach($seleksi as $item => $value) {
                $query .= "$item";
                if(is_array($value)) {
                    $query .= " IN (";
                    foreach($value as $items => $values) {
                        $query .= (array_search($item, $escapequote)!==false?"$values":"'$values'").",";
                    }
                    $query = rtrim($query, ",").")";

                } else {
                    $query .="=".(array_search($item, $escapequote)!==false?"$value":"'$value'");
                }
                $query.=" AND ";
            }
            
            //echo(rtrim($query, "AND "));
            $this->mysql_execute(rtrim($query, "AND "));
        }

        public function mysql_delete($tabel, $seleksi=array(), $escapequote=array()) {
            $query = "DELETE FROM $tabel " .(count($seleksi)>0?"WHERE ":"");
            
            foreach($seleksi as $item => $value) {
                $query .= "$item";
                if(is_array($value)) {
                    $query .= " IN (";
                    foreach($value as $items => $values) {
                        $query .= (array_search($item, $escapequote)!==false?"$values":"'$values'").",";
                    }
                    $query = rtrim($query, ",").")";

                } else {
                    $query .="=".(array_search($item, $escapequote)!==false?"$value":"'$value'");
                }
                $query.=" AND ";
            }
            
            //die($sql);
            $this->mysql_execute(rtrim($query, "AND "));
        }

        
        public function getFieldValue($tabel, $kolom=array(), $seleksi=array(), $escapequote=array(), $limit=0, $start=0, $orderBy="", $query="") {

            $sql = "SELECT ";
            foreach ($kolom as $key => $value) {
                $sql.="$value,";
            }
            $sql=rtrim($sql,","). " FROM $tabel WHERE 1";

            foreach($seleksi as $item => $value) {
                $sql .= " AND $item";
                if(is_array($value)) {
                    $sql .= " IN (";
                    foreach($value as $items => $values) {
                        $sql .= (array_search($item, $escapequote)!==false?mysqli_escape_string($values):"'".mysqli_escape_string($values)."'").",";
                    }
                    $sql = rtrim($sql, ",").")";

                } else {
                    $sql .="=".(array_search($item, $escapequote)!==false?"$value":"'$value'");
                }
            }
            if(strlen($query)>0) $sql.=" AND ". $query;
            
            if(strlen($orderBy)>0) $sql.=" ORDER BY $orderBy";
            if($limit>0) $sql.=" LIMIT $start, $limit";
            //echo($sql."<br /><br />");
            $this->mysql_query($sql, $rs_num, $result);
            return $result;
        }
        
        private function mysql_getError($err_mesg) {
            $this->mysql_close();
            die("{success: false, message: \"$err_mesg.\"}");
        }
    }