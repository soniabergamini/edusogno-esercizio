<?php
require_once 'controllers/Controller.php';
class DashboardController extends Controller
{
    // PRIVATE FUNCTIONS
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

    // PUBLIC FUNCTIONS
    public function index($session)
    {
        if ($session['login'] && isset($session['user_email']) && isset($session['role'])) {

            ob_start();

            // Get user data
            $resultData = $this->getUserDataByEmail($session['user_email']);
            $userData = $resultData->fetch_assoc();

            // Get events
            $userEvents = $this->getUserEventsByEMail($session['user_email']);
            $eventsData = $this->getAllEvents();
            $allEvents = [];
            while ($row = $eventsData->fetch_assoc()) {
                $allEvents[] = $row;
            }

            // Save data in session
            if ($userData || $userEvents) {
                
                $_SESSION['user_name'] = $userData['nome'];
                $_SESSION['user_surname'] = $userData['cognome'];
                $_SESSION['events'] = $userData['ruolo'] === 'admin' ? $allEvents : $userEvents;                
                $_SESSION['role'] = $userData['ruolo'];

                // Refresh page once
                if (!isset($_SESSION['refresh_page']) || !$_SESSION['refresh']) {
                    $_SESSION['refresh_page'] = true;
                    $_SESSION['refresh'] = true;
                    header("Refresh:0");
                }

                $path = $session['role'] === 'admin' ? 'partials/main-admin-dashboard.php' : 'partials/main-user-dashboard.php';
                include_once $path;
                return ob_get_clean();

            } else {
                $_SESSION['role'] = 'utente';
                include_once 'partials/main-user-dashboard.php';
                return ob_get_clean();
            }
        } 
        $this->redirect('/login');
    }
}
