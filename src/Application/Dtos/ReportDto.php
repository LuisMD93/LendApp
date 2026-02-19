<?php

namespace Application\Dtos;
use DateTime;
use JsonSerializable;

class ReportDto implements JsonSerializable{

        public int $id;
        public DateTime $creationDate;
        public string $loan_location;
        public string $productName;
        public int $amount;
        public bool $lendStatus;
        public string $description;
        public int $id_user;
        public DateTime $modificationDate;


        public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'loan_location' => $this->loan_location,
            'productName' => $this->productName,
            'amount' => $this->amount,
            'lendStatus' => $this->lendStatus,
            'description' => $this->description,
            'id_user' => $this->id_user,
            'creationDate' => $this->creationDate->format('Y-m-d H:i:s'),
            'modificationDate' => $this->modificationDate->format('Y-m-d H:i:s'),
        ];
    }


    public function __construct(int $id,string $loan_location = 'novedad',string $productName,int $amount,string $description   , bool $lendStatus,int $id_user     //RoleEnum $role = RoleEnum::UNDEFINED,
        ,DateTime $creationDate = new DateTime('0000-00-00 00:00:00'),
        DateTime $modificationDate = new DateTime('0000-00-00 00:00:00')) {

        $this->id = $id;
        $this->loan_location = $loan_location;
        $this->productName = $productName;
        $this->amount = $amount;
        $this->lendStatus = $lendStatus;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->modificationDate = $modificationDate;
        $this->id_user = $id_user;

        }

        public function setId(int $id) : void{
        $this->id = $id;
        }

        public function getId() : int {
            return $this->id;
        }

        public function setIdUser(int $id_user) : void{
        $this->id_user = $id_user;
        }

        public function getIdUser() : int {
            return $this->id_user;
        }

        public function setLoan_location(string $loan_location) : void {
        $this->loan_location = $loan_location;
        }

        public function getLoan_location() : string {
            return $this->loan_location;
        }

        public function setProductName(string $productName) : void {
            $this->productName = $productName;
        }

        public function getProducName() : string {
            return $this->productName;
        }

        public function setAmount(int $amount) : void {
            $this->amount = $amount;
        }

        public function getAmount() : int {
            return $this->amount;
        }


        public function getLendStatus(): bool {
            return $this->lendStatus;
        }

        public function setLendStatus(bool $lendStatus) {
            $this->lendStatus=$lendStatus;
        }
    
        public function setDescription(string $description) : void {
            $this->description = $description;
        }

        public function getDescription() : string {
            return $this->description;
        }

        public function getCreationDate(): DateTime {
            return $this->creationDate;
        }

        public function setCreationDate(DateTime $creationDate): void {
            $this->creationDate = $creationDate;
        }
        

        
        public function getModificationDate(): DateTime {
            return $this->modificationDate;
        }

        public function setModificationDate(DateTime $modificationDate): void {
            $this->modificationDate = $modificationDate;
        }
}