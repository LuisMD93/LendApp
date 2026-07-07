<?php

// namespace Domain\Models;
// use DateTime;
// use DateTimeZone;

// class Report {
    
//     private int $id;
//     private DateTime $creationDate;
//     private string $loan_location;
//     private string $productName;
//     private int $amount;
//     private bool $lendStatus;
//     private string $description;
//     private int $id_user;
//     private DateTime $modificationDate;


//     public function __construct(int $id,string $loan_location,string $productName,int $amount,string $description   , bool $lendStatus,int $id_user
//         ,DateTime $creationDate =new DateTime('now', new DateTimeZone('America/Bogota')),
//         DateTime $modificationDate = new DateTime('now', new DateTimeZone('America/Bogota'))) {

//        $this->id = $id;
//        $this->loan_location = $loan_location;
//        $this->productName = $productName;
//        $this->amount = $amount;
//        $this->lendStatus = $lendStatus;
//        $this->description = $description;
//        $this->creationDate = $creationDate;
//        $this->modificationDate = $modificationDate;
//        $this->id_user = $id_user;

//     }

//     public function setId(int $id) : void{
//        $this->id = $id;
//     }

//     public function getId() : int {
//         return $this->id;
//     }

//     public function setIdUser(int $id_user) : void{
//        $this->id_user = $id_user;
//     }

//     public function getIdUser() : int {
//         return $this->id_user;
//     }

//     public function setLoan_location(string $loan_location) : void {
//        $this->loan_location = $loan_location;
//     }

//     public function getLoan_location() : string {
//         return $this->loan_location;
//     }

//     public function setProductName(string $productName) : void {
//         $this->productName = $productName;
//     }

//     public function getProducName() : string {
//         return $this->productName;
//     }

//     public function setAmount(int $amount) : void {
//         $this->amount = $amount;
//     }

//     public function getAmount() : int {
//         return $this->amount;
//     }


//     public function getLendStatus(): bool {
//         return $this->lendStatus;
//     }

//     public function setLendStatus(bool $lendStatus) {
//          $this->lendStatus=$lendStatus;
//     }
   
//     public function setDescription(string $description) : void {
//         $this->description = $description;
//     }

//     public function getDescription() : string {
//         return $this->description;
//     }

//     public function getCreationDate(): DateTime {
//         return $this->creationDate;
//     }

//     public function setCreationDate(DateTime $creationDate): void {
//         $this->creationDate = $creationDate;
//     }
    

    
//     public function getModificationDate(): DateTime {
//         return $this->modificationDate;
//     }

//     public function setModificationDate(DateTime $modificationDate): void {
//         $this->modificationDate = $modificationDate;
//     }
// }




namespace Domain\Models;

use DateTime;
use DateTimeZone;

class Report
{
    private int $id;
    private DateTime $creationDate;
    private string $loan_location;
    private string $productName;
    private int $amount;
    private bool $lendStatus;
    private string $description;
    private User $user;
    private DateTime $modificationDate;


    public function __construct(
        int $id,
        string $loan_location,
        string $productName,
        int $amount,
        string $description,
        bool $lendStatus,
        User $user,
        ?DateTime $creationDate = null,
        ?DateTime $modificationDate = null
    ) {
        $this->id = $id;
        $this->loan_location = $loan_location;
        $this->productName = $productName;
        $this->amount = $amount;
        $this->lendStatus = $lendStatus;
        $this->description = $description;
        $this->user = $user;

        $this->creationDate = $creationDate ?? new DateTime(
            'now',
            new DateTimeZone('America/Bogota')
        );

        $this->modificationDate = $modificationDate ?? new DateTime(
            'now',
            new DateTimeZone('America/Bogota')
        );
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    public function getUser(): User
    {
        return $this->user;
    }


    public function setLoanLocation(string $loan_location): void
    {
        $this->loan_location = $loan_location;
    }


    public function getLoan_location(): string
    {
        return $this->loan_location;
    }


    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }


    public function getProducName(): string
    {
        return $this->productName;
    }


    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }


    public function setLendStatus(bool $lendStatus): void
    {
        $this->lendStatus = $lendStatus;
    }


    public function getLendStatus(): bool
    {
        return $this->lendStatus;
    }


    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function getDescription(): string
    {
        return $this->description;
    }


    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }


    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }


    public function getModificationDate(): DateTime
    {
        return $this->modificationDate;
    }


    public function setModificationDate(DateTime $modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }
}