<?php 
require_once __DIR__ . '/../models/Event.php';
require_once 'controllers/Controller.php';

class EventController extends Controller {
    public function createEvent() {

    }

    public function editEvent() {

    }

    public function destroyEvent() {
        if (isset($_POST['eventID']) && isset($_POST['eventAttendees']) && isset($_POST['eventName']) && isset($_POST['eventDate']) && isset($_POST['eventDescription'])) {

            $event = new Event($_POST['eventName'], $_POST['eventDate'], $_POST['eventAttendees'], $_POST['eventDescription']);
            $errors = $event->deleteEvent($_POST['eventID']);

            if(!$errors) {
                $_SESSION['refresh'] = false;
                $this->redirect('/dashboard');
            }else {
                $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile cancellare l\'evento. Riprova più tardi.';
                $this->redirect('/dashboard');
            }
        }
        $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile cancellare l\'evento. Riprova più tardi.';
        $this->redirect('/dashboard');
    }    
}

?>