<?php
require_once 'UserAccEntity.php';
require_once 'UserProfileEntity.php';

class AdminCreateUAController {
    private $entity, $entityP;

    public function __construct () {
        $this->entity = new UserAccEntity();
        $this->entityP = new UserProfileEntity();
    }

    public function createAccount ($Username, $Email, $Password, $activeStatus, $Profile_id) {
        $result = $this->entity->createUserAccount($Username, $Email, $Password, $activeStatus, $Profile_id);
        return $result;
    }

    public function getUserProfiles () {
        $profiles = $this->entityP->getUserProfiles();

        return $profiles;
    }

    public function accountExists($accountUsername) {
        $accounts = $this->entity->getUserAccounts();
    
        foreach ($accounts as $account) {
            // Retrieve the name of the account
            $username = $account->getUsername();
            if ($username === $accountUsername) {
                return ["exists" => true]; 
            }
        }
        return ["exists" => false]; 
    }
}

?>