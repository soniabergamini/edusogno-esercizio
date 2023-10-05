<?php
class DashboardController
{

    // PRIVATE FUNCTIONS
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
            $this->setErrorRedirect(
                '🫤 Errore di connessione',
                'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.',
                '/404'
            );
            return;
        }
        return $conn;
    }

    private function setErrorRedirect($errorTitle, $errorMessage, $url)
    {
        $_SESSION['error_title'] = $errorTitle;
        $_SESSION['error_message'] = $errorMessage;
        $this->redirect($url);
    }

    private function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    private function getUserDataByEMail($email)
    {
        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("SELECT nome, cognome FROM utenti WHERE email = (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        return $result;
    }

    private function getUserEventsByEMail($email)
    {

        // Prepared Statements
        try {
            $conn = $this->getDBConnection();
            $stmt = $conn->prepare("SELECT nome_evento, data_evento FROM eventi WHERE FIND_IN_SET(?, attendees) > 0");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = [
                    'nome_evento' => $row['nome_evento'],
                    'data_evento' => $row['data_evento'],
                ];
            }
            $stmt->close();
            $conn->close();
            return $events;
        } catch (mysqli_sql_exception $e) {
            $this->setErrorRedirect(
                '🫤 Errore nel recupero degli eventi',
                'Si è verificato un errore durante il recupero dei tuoi eventi. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.',
                '/dashboard'
            );
        }
    }

    public function index($session)
    {
        if ($session['login'] && isset($session['user_email'])) {

            ob_start();

            // Get user data
            $resultData = $this->getUserDataByEMail($session['user_email']);
            $userData = $resultData->fetch_assoc();

            // Get user events
            $userEvents = $this->getUserEventsByEMail($session['user_email']);

            // Save data in session
            if ($userData || $userEvents) {
                
                $_SESSION['user_name'] = $userData['nome'];
                $_SESSION['user_surname'] = $userData['cognome'];
                $_SESSION['user_events'] = $userEvents;

                // Refresh page once
                if (!isset($_SESSION['refresh_page'])) {
                    $_SESSION['refresh_page'] = true;
                    header("Refresh:0");
                }

                include_once 'partials/main-dashboard.php';
                return ob_get_clean();

            } else {
                include_once 'partials/main-dashboard.php';
                return ob_get_clean();
            }
        } 
        $this->redirect('/login');
    }
}
