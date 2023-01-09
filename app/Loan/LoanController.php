<?php


namespace App\Loan;


class LoanController
{
    /**
     * @var Loan
     */
    protected $loan;
    protected $id;

    public function __construct(Loan $loan, $id)
    {
        $this->loan = $loan;
        $this->id = $id;
    }


    public function show()
    {
        $this->loan->getInfo($this->id);
    }

}
