<?php

class UserService {

    public function createUser($currentUserId, $name, $passwort, $vorname, $nachname, $email, $rolle) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=create_user&user=%s&name=%s&passwort=%s&vorname=%s&nachname=%s&email=%s&rolle=%s', $currentUserId, $name, $passwort, $vorname, $nachname, $email, $rolle
            )
        );

        return $urlWrapper->getDecodedContent(false);
    }

    //testen bei Benutzerbearbeiten, unter der bedingung, das es auch alle angaben drinne bleiben
    public function getUsers($userid) {

        $urlWrapper = new UrlWrapper('http://localhost/Basteln/index.php?do=getuserlist&user=' . $userid);

       
            
        
        return $urlWrapper->getDecodedContent (false);
    }

    public function createUser_register($name, $passwort, $vorname, $nachname, $email) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=create_user&name=%s&passwort=%s&vorname=%s&nachname=%s&email=%s&rolle=locked', $name, $passwort, $vorname, $nachname, $email
            )
        );

        return $urlWrapper->getDecodedContent(false);
    }

    public function work_user($currentUserId, $id, $rolle, $name, $vorname, $nachname, $email) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=work_user&user=%s&id=%s&rolle=%s&name=%s&vorname=%s&nachname=%s&email=%s', $currentUserId, $id, $rolle, $name, $vorname, $nachname, $email
            )
        );
        return $urlWrapper->getDecodedContent(false);
    }

    public function password_changed($user, $oldpwd, $newpwd) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=changepwd&user=%s&oldpwd=%s&newpwd=%s', $user, $oldpwd, $newpwd
            )
        );
        return $urlWrapper->getDecodedContent(false);
    }

    public function getuser($currentuserid, $id) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=getuser&id=%s&user=%s', $currentuserid, $id
            )
        );
        return $urlWrapper->getDecodedContent(false);
    }

    public function create_project($currentuserid, $name) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                'http://localhost/Basteln/index.php?do=create_projecte&user=%s&name=%s', $currentuserid, $name
            )
        );

        return $urlWrapper->getDecodedContent(false);
    }

    public function get_projects($currentuserid, $status) {
        $urlWrapper = new UrlWrapper(
                     'http://localhost/Basteln/index.php?do=get_projects&user=' . $currentuserid . '&status='. $status
            
        );
        return $urlWrapper->getDecodedContent(false);
    }
    public function edit_project($currentuserid, $id, $name, $status) {
        $urlWrapper = new UrlWrapper(
            sprintf(
                     'http://localhost/Basteln/index.php?do=edit_project&user=%s&id=%s&name=%s&status=%s', $currentuserid, $id, $name, $status     
                )
        );
        return $urlWrapper->getDecodedContent(false);
    }
     public function get_project($currentuserid, $id) {
        $urlWrapper = new UrlWrapper(
                     'http://localhost/Basteln/index.php?do=get_project&user=' . $currentuserid . '&id='. $id
            
        );
        return $urlWrapper->getDecodedContent(false);
    }
    public function push ($user, $project, $groesse) {
        $urlWrapper = new UrlWrapper(
            sprintf(
            'http://localhost/Basteln/index.php?do=push_project&user=%s&project=%s&groesse=%s',
            $user,
            $project,
            $groesse)
       );
         return $urlWrapper->getDecodedContent(false);
     }
     public function pull ( $user, $project) {
         $urlWrapper = new UrlWrapper(
             sprintf(
             'http://localhost/Basteln/index.php?do=pull_project&user=%s&project=%s',
             $user,
             $project
              )
             );
         return $urlWrapper->getDecodedContent(false);
     }
     public function loeschen($project, $versionsnummer) {
         $urlWrapper = new UrlWrapper(
             sprintf(
             'http://localhost/Basteln/index.php?do=loeschen&project=%s&versionsnummer=%s',
             $project,
             $versionsnummer
             )
             );
         return $urlWrapper->getDecodedContent(false);
     }
     public function loeschen_test($project) {
         $urlWrapper = new UrlWrapper(
             sprintf(
             'http://localhost/Basteln/index.php?do=loeschen&project=%s',
             $project
            
             )
             );
         return $urlWrapper->getDecodedContent(false);
     }
     public function project_loeschen($project) {
         $urlWrapper = new UrlWrapper(
             sprintf(
             'http://localhost/Basteln/index.php?do=project_loeschen&project=%s',
             $project
             )
             );
         return $urlWrapper->getDecodedContent(false);
     }
}