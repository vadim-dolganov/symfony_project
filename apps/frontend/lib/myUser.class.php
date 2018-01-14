<?php

class myUser extends sfBasicSecurityUser
{
    private const LOGGED_USER = 'loggedUser';

    public function logIn(User $userFromDatabase)
    {
        $this->setAuthenticated(true);
        $this->setAttribute(myUser::LOGGED_USER, $userFromDatabase);
        $this->addCredential($userFromDatabase->getRole());
    }

    public function logOut()
    {
        if ($this->isAuthenticated())
        {
            $this->setAuthenticated(false);
            $this->clearCredentials();
        }
    }

    public function getLoggedUser()
    {
        return ($this->hasAttribute(myUser::LOGGED_USER)) ? $this->getAttribute(myUser::LOGGED_USER) : null;
    }

    public function isAdmin()
    {
        return $this->hasCredential(UserRole::ADMIN);
    }

    public function getUserRole(): string
    {
        return $this->getLoggedUser()->getRole();
    }

    public function getId(): int
    {
        return $this->getLoggedUser()->getId();
    }

    public function getLogin(): string
    {
        return $this->getLoggedUser()->getLogin();
    }

    public function updateLoggedUser(string $firstName, string $lastName)
    {
        $loggedUser = $this->getLoggedUser();
        $loggedUser->setFirstName($firstName);
        $loggedUser->setLastName($lastName);
    }
}
