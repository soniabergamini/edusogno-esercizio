<?php 

class Event {

    // PROPERTIES
    private string $name;
    private $date;
    private string $attendees;
    private string $description;

    // CONSTRUCTOR
    public function __construct($name , $date, $attendees, $description)
    {
        $this->name = $name;
        $this->date = $date;
        $this->attendees = $attendees;
        $this->description = $description;
    }

    // GETTER
    public function getEventName()
    {
        return $this->name;
    }

    public function getEventDate()
    {
        return $this->date;
    }

    public function getEventAttendees()
    {
        return $this->attendees;
    }

    public function getEventDescription()
    {
        return $this->description;
    }

    // SETTER
    public function setEventName($name)
    {
        $this->name = $name;
    }

    public function setEventDate($date)
    {
        $this->date = $date;
    }

    public function setEventAttendees($attendees)
    {
        $this->attendees = $attendees;
    }

    public function setEventDescription($description)
    {
        $this->description = $description;
    }

    // ACTIONS
    public function deleteEvent($eventID) {

        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("DELETE FROM eventi WHERE id = (?)");
        $stmt->bind_param("s", $eventID);
        $stmt->execute();
        $errors = $stmt->error;
        $stmt->close();
        $conn->close();

        return $errors;
        
    }

    public function updateEvent($eventID) {

        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("UPDATE eventi SET nome_evento = (?), data_evento = (?), attendees = (?), descrizione = (?) WHERE id = (?)");
        $stmt->bind_param("ssssi", $this->name, $this->date, $this->attendees, $this->description, $eventID);
        $stmt->execute();
        $errors = $stmt->error;
        $stmt->close();
        $conn->close();

        return $errors;
        
    }

    // PRIVATE METHODS
    private function getDBConnection()
    {
        $envFile = file_get_contents('.env');
        parse_str(str_replace(PHP_EOL, '&', $envFile), $env);
        $conn = null;
        $connError = null;
        try {
            $conn = new mysqli($env['DB_SERVERNAME'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_NAME'], $env['DB_PORT']);
        } catch (mysqli_sql_exception $e) {
            $connError = $e->getMessage();
        }
        if ($conn->connect_error || $connError !== null) {
            $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile cancellare l\'evento. Riprova più tardi.';
            header('Location: /dashboard');
            exit();
        }
        return $conn;
    }
}
?>