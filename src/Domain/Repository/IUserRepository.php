<?php

namespace Domain\Repository;

use Domain\Models\User;

interface IUserRepository {

       function createUser(User $user) : bool;
       function getAllUsers(): array;
       function searchUserByPhone(string $phone) : bool;
       function deleteUserById(int $Id) : bool;
       function findUserById(int $Id) : bool;
       function updateUser(User $user) :bool;
       function existsUser(string $email,string $phone) : bool;
       function login(string $userName,string $phone) : array;
}