<?php


namespace App\Statements;


class StatementController
{

    protected $statement;

    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }


    public function statement()
    {
        return $this->statement->getStatement();
    }



}
