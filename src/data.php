<?php

    class Data
    {

        private $user = "dev";
        private $pass = "dev";
        private $host = "db";
        private $db   = "myapp";

        private $conn = null;

        public function __construct()
        {
            $this->connect();
        }

        private function connect()
        {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            mysqli_set_charset($this->conn, "utf-8");
            if ($this->conn->connect_error)
                die("Connection failed: " . $conn->connect_error);
        }

        public function getAll()
        {
            // Sql sentence to extract from db
            $sql = "SELECT id, temperature, humidity, DATE_FORMAT(date,'%d-%M-%Y %h:%i:%s')
            FROM temperatures 
            WHERE date >= (SELECT MAX(date) FROM temperatures)  - INTERVAL 10 MINUTE";

            // Execute query
            $result = mysqli_query($this->conn, $sql);

            // Init arrays to store results

            $data = array();
            $fecha = null;
            // $dates = array();

            if ($row = mysqli_fetch_row($result))
            {
                $data[] = $row[1];
                $data[] = $row[2];
                $fecha = $row[3];
            }

            $json_data = json_encode($data);

            // Return array values and array dates in associative array
            return array("data" => $json_data, "fecha" => $fecha);
        }

        public function lastHourValues() {
            // Sql sentence to extract from db
            $sql = "SELECT id, temperature, humidity, DATE_FORMAT(date,'%h:%i:%s')
                    FROM temperatures 
                    WHERE date >= (SELECT MAX(date) FROM temperatures) - INTERVAL 1 HOUR";

            // Execute query
            $result = mysqli_query($this->conn, $sql);

            // Init arrays to store results
            $temperatures = array();
            $humidities = array();
            $dates = array();

            // Store results
            while($row = mysqli_fetch_row($result)) {
                $temperatures[] = $row[1];
                $humidities[] = $row[2];
                $dates[] = $row[3];
            }

            // Convert to json objects
            $json_temperatures = json_encode($temperatures);
            $json_humidities  = json_encode($humidities);
            $json_dates = json_encode($dates);


            // Return array values and array dates in associative array
            return array("temperatures" => $json_temperatures, "humidities" => $json_humidities, "dates" => $json_dates);
        }

		public function __destruct()
		{
			$this->conn->close();
		}

    }

?>