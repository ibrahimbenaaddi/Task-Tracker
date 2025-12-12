<?php

namespace App\Model;

class Task
{
    private int $id;
    private string $description;
    private string $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, string $desc)
    {
        $this->id = $id;
        $this->description = $desc;
        $this->status = "todo";
        $this->createdAt = date("Y-m-d H:i:s");
        $this->updatedAt = date("Y-m-d H:i:s");
    }

    public function infoTask():array
    {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "status" => $this->status,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt
        ];
    }
}
