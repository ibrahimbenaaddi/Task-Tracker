<?php

namespace App;

class task
{
    private int $id;
    private string $description;
    private string $status;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id, string $desc, string $status)
    {
        $this->id = $id;
        $this->description = $desc;
        $this->status = $status;
        $this->createdAt = date("Y-m-d H:i:s");
        $this->updatedAt = date("Y-m-d H:i:s");
    }
}
