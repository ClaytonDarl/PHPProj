<?php
    /**
     * A general class to handle session management
     */
    class Session {

        private $signedIn = false;
        public $userId;
        public $aMessage;
        public $admin = false;
        public $count;

        /**
         * Auto start the session and check if the user is logged in.
         */
        function __construct() {
            session_start();
            $this->visitCount();
            $this->checkLogin();
            $this->checkMessage();
        }

        public function visitCount() {
            if (isset($_SESSION['count'])) {
                return $this->count = $_SESSION['count']++;
            } else {
                return $_SESSION['count'] = 1;
            }
        }

        public function message($msg="") {
            if(!empty($msg)) {
                $_SESSION['message'] = $msg;
            } else {
                return $this->aMessage;
            }
        }

        private function checkMessage() {
            if (isset($_SESSION['message'])) {
                $this->aMessage = $_SESSION['message'];
                unset($_SESSION['message']);
            } else {
                $this->message = "";
            }
        }
        /**
         * If a session is active, assign the Session's userId and mark the user as logged in
         *
         * @return void
         */
        private function checkLogin() {
            //if the session exists, then set session values
            if (isset($_SESSION['user_id'])) {
                $this->userId = $_SESSION['user_id'];
                $this->signedIn = true;
            } else {
                unset($this->userId);
                unset($this->userName);
                $this->signedIn = false;
            }
        }

        /**
         * Get the sign in status
         *
         * @return boolean Returns the value of signedIn
         */
        public function isSignedIn() {
            return $this->signedIn;
        }

        //check if the user as admin permission
        public function checkPermission() {
            return $_SESSION['admin'];
        }

        /**
         * Sign the user in. Assigns the user id to the global session id and marks the user as logged in
         *
         * @param User $user The user trying to login
         * @return void
         */
        public function login($user) {
            if ($user) {
                //assign the sessions user id to the global user_id, then assign the User id from the object
                $this->userId = $_SESSION['user_id'] = $user->id;
                $this->signedIn = true;
                if($user->permission == 1) {
                    $this->admin = $_SESSION['admin'] = true;
                } else {
                    $this->admin = $_SESSION['admin'] = false;
                }
            }
        }

        /**
         * Logs the current user out. Unsets the userId and sets signedIn to false
         *
         * @return void
         */
        public function logout() {
            unset($this->userId);
            unset($_SESSION['user_id']);
            $this->signedIn = false;
            unset($this->admin);
            unset($this->userName);
        }
    }
    $session = new Session();
?>